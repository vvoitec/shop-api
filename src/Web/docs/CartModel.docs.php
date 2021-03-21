<?php

/**
 * @OA\Schema(
 *     description="Cart model",
 *     title="Cart model",
 *     required={"prodcuts"},
 * )
 */
class CartModel {
    /**
     * @OA\Property(
     *     description="products",
     *     title="products",
     *     @OA\Items(
     *          type="integer",
     *     )
     * )
     *
     * @var array
     */
    private array $products;
}
