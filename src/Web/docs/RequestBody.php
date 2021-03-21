<?php

/**
 *
 * @OA\RequestBody(
 *     request="Product",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/ProductModel"),
 * )
 *
 * @OA\RequestBody(
 *     request="Cart",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/CartModel"),
 * )
 */