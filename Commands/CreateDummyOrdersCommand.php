<?php

namespace Commands;

use Helpers\Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;
use Faker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CreateDummyOrdersCommand extends Command
{
    protected static $defaultName = 'simpler:create-dummy-orders';


    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $faker = Faker\Factory::create();
        $products = Capsule::table('product')
            ->join('product_description' , 'product_description.product_id', 'product.product_id')
            ->inRandomOrder()
            ->take(rand(4, 10))
            ->get();

        $total = $products->sum('price');

        for ($i = 0; $i <= 10; $i++) {
            $orderId = Capsule::table('order')
                ->insertGetId([
                    "invoice_no" => $faker->randomNumber(5),
                    "invoice_prefix" => "INV-2024-00",
                    "store_id" => "0",
                    "store_name" => "Your Store",
                    "store_url" => "http://localhost/",
                    "customer_id" => "0",
                    "customer_group_id" => "1",
                    "firstname" => $faker->firstName(),
                    "lastname" => $faker->lastName(),
                    "email" => $faker->email(),
                    "telephone" => $faker->phoneNumber(),
                    "fax" => "",
                    "custom_field" => "[]",
                    "payment_firstname" => $faker->firstName(),
                    "payment_lastname" => $faker->lastName(),
                    "payment_company" => $faker->company(),
                    "payment_address_1" => $faker->address(),
                    "payment_address_2" => "",
                    "payment_city" => $faker->city(),
                    "payment_postcode" => $faker->postcode(),
                    "payment_country" => "Greece",
                    "payment_country_id" => "84",
                    "payment_zone" => "Attica",
                    "payment_zone_id" => "1280",
                    "payment_address_format" => "",
                    "payment_custom_field" => "[]",
                    "payment_method" => "Cash On Delivery",
                    "payment_code" => "cod",
                    "shipping_firstname" => $faker->firstName(),
                    "shipping_lastname" => $faker->lastName(),
                    "shipping_company" => $faker->company(),
                    "shipping_address_1" => $faker->address(),
                    "shipping_address_2" => "",
                    "shipping_city" => $faker->city(),
                    "shipping_postcode" => $faker->postcode(),
                    "shipping_country" => "Greece",
                    "shipping_country_id" => "84",
                    "shipping_zone" => "Attica",
                    "shipping_zone_id" => "1280",
                    "shipping_address_format" => "",
                    "shipping_custom_field" => "[]",
                    "shipping_method" => "Flat Shipping Rate",
                    "shipping_code" => "flat.flat",
                    "comment" => $faker->text('50'),
                    "total" => $total,
                    "order_status_id" => "1",
                    "affiliate_id" => "0",
                    "commission" => "0.0000",
                    "marketing_id" => "0",
                    "tracking" => "",
                    "language_id" => "1",
                    "currency_id" => "2",
                    "currency_code" => "USD",
                    "currency_value" => "1.00000000",
                    "ip" => $faker->ipv4(),
                    "forwarded_ip" => $faker->ipv4(),
                    "user_agent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36",
                    "accept_language" => "el-GR,el;q=0.9,en;q=0.8,la;q=0.7,fr;q=0.6",
                    "date_added" => Carbon::now(),
                    "date_modified" => Carbon::now(),
                ]);

            foreach ($products as $product) {

                Capsule::table('order_product')
                    ->insert([
                        'order_id' => $orderId,
                        'product_id' => $product->product_id,
                        'name' => $product->name,
                        'model' => $product->model,
                        'quantity' => 1,
                        'price' => $product->price,
                        'total' => $product->price,
                        'tax' => "0.0000",
                        'reward' => 0,
                    ]);
            }

            Capsule::table('order_total')
                ->insert([
                    [
                        'order_id' => $orderId,
                        'code' => 'sub_total',
                        'title' => 'Sub-Total',
                        'value' => $total,
                        'sort_order' => 0,
                    ],
                    [
                        'order_id' => $orderId,
                        'code' => 'shipping',
                        'title' => 'Flat Shipping Rate',
                        'value' => 5,
                        'sort_order' => 0,
                    ],
                    [
                        'order_id' => $orderId,
                        'code' => 'total',
                        'title' => 'Total',
                        'value' => $total + 5,
                        'sort_order' => 0,
                    ]
                ]);
        }

        $output->writeln('Dummy Orders Created');
        return Command::SUCCESS;
    }

}
