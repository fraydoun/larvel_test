<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FormItem;
use Illuminate\Database\Seeder;

class FormItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    const items = [
            [
                'title' => 'عنوان را وارد کنید',
                'slug'  => 'title',
                'type_field' => 'text',
                'price' => null,
                'settings' => [
                    'min' => 10,
                    'max' => 100,
                    'direction' => 'rtl',
                    'placeHolder' => 'this is hint',
                    'required' => true,
                    'style' => null,
                    'class' => null,
                    'value' => null,
                ]
            ],
            [
                'title' => 'سن را وارد کنید', 
                'slug'  => 'age',
                'type_field' => 'number',
                'price' => null,
                'settings' => [
                    'min' => 10,
                    'max' => 100,
                    'placeHolder' => 'this is hint',
                    'direction' => 'ltr',
                    'required' => true,
                    'style' => null,
                    'class' => null,
                    'value' => null,
                ]
            ],
            [
                'title' => 'جنسیت را انتخاب کنید',
                'slug'  => 'gender',
                'type_field' => 'one_select',
                'price' => null,
                'settings' => [
                    'options' => [
                        'male' => 'مذکر',
                        'famle' => 'مونث',
                        'other' => 'غیره'
                    ],
                    'placeHolder' => 'this is hint',
                    'direction' => 'rtl',
                    'required' => false,
                    'style' => null,
                    'class' => null,
                    'value' => null,
                ]
            ],
            [
                'title' => 'ویژگی های اضافه را انتخاب کنید',
                'slug'  => 'features',
                'type_field' => 'multi_select',
                'price' => null,
                'settings' => [
                    'options' => [
                        'room' => 'اتاق اضافه',
                        'yard' => 'حیاط',
                        'parking' => 'پارکینگ',
                        'garden' => 'باغچه',
                    ],
                    'placeHolder' => 'this is hint',
                    'direction' => 'rtl',
                    'required' => true,
                    'style' => null,
                    'class' => null,
                    'value' => null,
                ]
            ],
            [
                'title' => 'توضیحات را وارد کنید',
                'slug'  => 'description',
                'type_field' => 'textarea',
                'price' => null,
                'settings' => [
                    'direction' => 'rtl',
                    'cols' => 6,
                    'placeHolder' => 'this is hint',
                    'required' => true,
                    'style' => null,
                    'class' => null,
                    'value' => null,
                    'min' => 20,
                    'max' => 500,
                ]
            ],
            [
                'title' => 'نشان فوری (۱۰۰۰ تومان)',
                'slug'  => 'force_label',
                'type_field' => 'bool',
                'price' => 1000,
                'settings' => [
                    'style' => null,
                    'class' => null,
                    'value' => true,
                ]
            ],
            [
                'title' => 'یکی از موارد زیر را انتخاب کنید',
                'slug' => 'selct_one',
                'type_field' => 'radio_group',
                'price' => null,
                'settings' => [
                    'type_show' => 'horizontal',
                    'options' => [
                        'personal' => 'شخصی', 
                        'business' => 'کسب کار'
                    ],
                    'style' => null,
                    'class' => null,
                    'value' => null,
                ]
            ],
            [
                'title' => 'یک از موارد زیر را انتخاب کنید',
                'slug' => 'select_one2',
                'type_field' => 'radio_group',
                'price' => null,
                'settings' => [
                    'type_show' => 'vertical',
                    'options' => [
                        'personal' => 'شخصی', 
                        'business' => 'کسب کار'
                    ]
                ]
            ]

    ];
    public function run()
    {
        $category = Category::find(1);
        foreach(self::items as $item){
            $formItem = FormItem::create($item);
            $category->relForm()->attach($formItem);
        }
    }
}
