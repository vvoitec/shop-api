<?php

/**
 * @OA\Schema(
 *     description="Product model",
 *     title="Product model",
 *     required={"title", "price"},
 * )
 */
class ProductModel {
    /**
     * @OA\Property(
     *     description="Unique title",
     *     title="title",
     * )
     *
     * @var string
     */
    private string $title;

    /**
     * @OA\Property(
     *     description="price",
     *     title="price",
     * )
     *
     * @var string
     */
    private string $price;
}
