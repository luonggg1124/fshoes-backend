<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Nike Sportswear Destroyer',
                'Nike Pro 365',
                'Jordan Chicago',
                'Flex Runner 3',
                'Air Jordan 1 Low',
                'Revolution 7 EasyOn',
                'Nike P-6000',
                'Air Force 1 ',
                'Sportswear Premium Essentials',
                'Sportswear',
                'Brazil 1998 Reissue',
                'ACG Therma-FIT'
            ]),
            'slug' => $this->faker->slug(),
            'image_url' => $this->faker->randomElement([
                'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/70dc23a3-5054-46c1-acd2-0db28bbf8855/WMNS+AIR+FORCE+1+%2707.png',
                'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/12a2f74f-b392-4ff1-8d15-480de194bd0c/AIR+ZOOM+PEGASUS+41.png',
                'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/59e18bd5-90eb-4f25-874d-0d9467d3a2a1/W+NIKE+V2K+RUN+GTX.png',
                'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/1b1c2359-c574-4706-86c7-f41cbcda9554/COURT+SHOT.png',
                'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco,u_126ab356-44d8-4a06-89b4-fcdcc8df0245,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/2197feec-9ae7-47e3-bbe4-a5c5198d5c8d/AIR+JORDAN+MULE.png',
                'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/ab4cb90c-58cc-4a03-9b72-2796249611ac/W+NIKE+AIR+PEGASUS+2005.png',
                'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/ab4cb90c-58cc-4a03-9b72-2796249611ac/W+NIKE+AIR+PEGASUS+2005.png',
              
            ]),
            'price' => $this->faker->numberBetween(1000, 999999),
            'description' => $this->faker->text(),
            'short_description' => $this->faker->text(),
            'stock_qty' => $this->faker->numberBetween(50, 70),
            'qty_sold' => $this->faker->numberBetween(50, 70),


        ];
    }
}
