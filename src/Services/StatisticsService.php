<?php

namespace Leeuwenkasteel\Statistics\Services;

use Carbon\Carbon;
use Leeuwenkasteel\Cashdesk\Models\Receipt;

class StatisticsService
{
    public function receipts(Carbon $from, Carbon $to)
    {
        return Receipt::with([
            'lines.product.translations',
            'lines.product.supplier',
            'lines.button.single.supplier',
            'lines.button.single',
            'payments.method.btn',
        ])
        ->whereBetween('paid_at', [
            $from->copy()->startOfDay(),
            $to->copy()->endOfDay(),
        ])
        ->where('status', 'paid');
    }

    public function summary(Carbon $from, Carbon $to): array
    {
        $receipts = $this->receipts($from, $to)->get();

        $income = $receipts->sum('total');
        $count = $receipts->count();

        return [
            'income' => round($income, 2),
            'count' => $count,
            'average' => $count > 0
                ? round($income / $count, 2)
                : 0,
            'refunds' => round(
                $receipts
                    ->filter(fn ($receipt) => $receipt->total < 0)
                    ->sum('total'),
                2
            ),
        ];
    }

    public function payments(Carbon $from, Carbon $to): array
    {
        $receipts = $this->receipts($from, $to)->get();

        $payments = [];

        foreach ($receipts as $receipt) {
            if (!$receipt->payments || $receipt->payments->isEmpty()) {
                $method = 'Onbekend';

                $payments[$method] ??= 0;
                $payments[$method] += $receipt->total;

                continue;
            }

            foreach ($receipt->payments as $payment) {
                $method = optional($payment->method)->title ?? 'Onbekend';

                $payments[$method] ??= 0;
                $payments[$method] += $payment->amount;
            }
        }

        arsort($payments);

        return collect($payments)
            ->map(fn ($amount, $method) => [
                'method' => $method,
                'amount' => round($amount, 2),
            ])
            ->values()
            ->toArray();
    }

    public function products(Carbon $from, Carbon $to): array
    {
        $receipts = $this->receipts($from, $to)->get();

        $products = [];

        foreach ($receipts as $receipt) {
            foreach ($receipt->lines as $line) {

                $product = $line->product;
                $button = $line->button?->single;

                if ($product) {
                    $key = 'product_' . $product->id;

                    $name = $product->translations->title ?? 'Product';
                    $nr = $product->nr ?? null;
                    $supplier = optional($product->supplier)->name;
                } elseif ($button) {
                    $key = 'button_' . $button->id;

                    $name = $button->title ?? 'Button';
                    $nr = $button->nr ?? null;
                    $supplier = optional($button->supplier)->name;
                } else {
                    $key = 'other';

                    $name = 'Overig';
                    $nr = null;
                    $supplier = null;
                }

                $price =
                    ($line->price * (1 - (($line->discount ?? 0) / 100)))
                    * $line->quantity;

                $products[$key] ??= [
                    'nr' => $nr,
                    'name' => $name,
                    'supplier' => $supplier,
                    'quantity' => 0,
                    'total' => 0,
                ];

                $products[$key]['quantity'] += $line->quantity;
                $products[$key]['total'] += $price;
            }
        }

        foreach ($products as &$product) {
            $product['quantity'] = round($product['quantity'], 2);
            $product['total'] = round($product['total'], 2);
        }

        return $products;
    }

    public function daily(Carbon $from, Carbon $to): array
    {
        $receipts = $this->receipts($from, $to)->get();

        $days = [];

        foreach ($receipts as $receipt) {
            $date = Carbon::parse($receipt->paid_at)->format('Y-m-d');

            $days[$date] ??= [
                'date' => $date,
                'count' => 0,
                'total' => 0,
            ];

            $days[$date]['count']++;
            $days[$date]['total'] += $receipt->total;
        }

        ksort($days);

        foreach ($days as &$day) {
            $day['total'] = round($day['total'], 2);
        }

        return array_values($days);
    }

    public function vat(Carbon $from, Carbon $to): array
    {
        $receipts = $this->receipts($from, $to)->get();

        $vat = [
            0 => [
                'rate' => 0,
                'base' => 0,
                'vat' => 0,
                'total' => 0,
            ],
            9 => [
                'rate' => 9,
                'base' => 0,
                'vat' => 0,
                'total' => 0,
            ],
            21 => [
                'rate' => 21,
                'base' => 0,
                'vat' => 0,
                'total' => 0,
            ],
        ];

        foreach ($receipts as $receipt) {
            foreach ($receipt->lines as $line) {

                $product = $line->product;
                $button = $line->button?->single;

                $rate = (int) (
                    $product->btw
                    ?? $button->btw
                    ?? 0
                );

                if (!isset($vat[$rate])) {
                    $vat[$rate] = [
                        'rate' => $rate,
                        'base' => 0,
                        'vat' => 0,
                        'total' => 0,
                    ];
                }

                $total =
                    ($line->price * (1 - (($line->discount ?? 0) / 100)))
                    * $line->quantity;

                $vatAmount = match ($rate) {
                    9 => $total - ($total / 1.09),
                    21 => $total - ($total / 1.21),
                    default => 0,
                };

                $base = $total - $vatAmount;

                $vat[$rate]['base'] += $base;
                $vat[$rate]['vat'] += $vatAmount;
                $vat[$rate]['total'] += $total;
            }
        }

        foreach ($vat as &$row) {
            $row['base'] = round($row['base'], 2);
            $row['vat'] = round($row['vat'], 2);
            $row['total'] = round($row['total'], 2);
        }

        return array_values($vat);
    }
}