```php
<?php

declare(strict_types=1);

class Product
{
    public string $sku;
    public string $name;
    public int $categoryId;
    public int $price;
    public int $qty;

    public function __construct(
        string $sku,
        string $name,
        int $categoryId,
        int $price,
        int $qty
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->price = $price;
        $this->qty = $qty;
    }

    /**
     * Tính thành tiền sản phẩm
     * price * qty
     */
    public function lineTotal(): int
    {
        return $this->price * $this->qty;
    }

    /**
     * Kiểm tra mức tồn kho
     * Theo CANONICAL-DATA
     */
    public function stockLevel(): string
    {
        if ($this->qty >= 5) {
            return 'Du';
        }

        if ($this->qty >= 2) {
            return 'Sap het';
        }

        return 'Can nhap';
    }

    /**
     * Chuyển object thành array để debug
     */
    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'category_id' => $this->categoryId,
            'price' => $this->price,
            'qty' => $this->qty,
            'line_total' => $this->lineTotal(),
            'stock' => $this->stockLevel()
        ];
    }
}
```
