<?php

namespace Database\Factories;

use App\Models\Producto; // <-- añadido
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class; // <-- añadido

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->ean13(), // Código de barras EAN-13 único
            'nombre' => $this->faker->word(), // Nombre del producto
            'descripcion' => $this->faker->sentence(), // Descripción del producto
            'imagen' => $this->faker->imageUrl(640, 480, 'products', true), // URL de la imagen del producto
            'stock' => $this->faker->numberBetween(10, 100), // Stock actual
            'stock_minimo' => $this->faker->numberBetween(5, 10), // Stock mínimo
            'stock_maximo' => $this->faker->numberBetween(50, 200), // Stock máximo
            'precio_compra' => $this->faker->randomFloat(2, 10, 500), // Precio de compra
            'precio_venta' => $this->faker->randomFloat(2, 20, 600), // Precio de venta
            'fecha_ingreso' => $this->faker->date(), // Fecha de ingreso 
            'categoria_id' => 2, // Asumiendo que tienes una fábrica para Categoría
            'empresa_id' => 1, // Asumiendo que tienes una fábrica para Empresa
        ];
    }
}
