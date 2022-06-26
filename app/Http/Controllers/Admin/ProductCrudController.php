<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\ProductModel;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addFilter(
            [
                'name'  => 'category_id',
                'type'  => 'select2',
                'label' => 'Category',
            ],
            function () {
                $categories = [];
                foreach (Category::all() as $item) {
                    $categories[$item->id] = $item->name;
                }
                return $categories;
            },
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'category_id', '=', $value);
            }
        );
        CRUD::addFilter(
            [
                'name'  => 'brand_id',
                'type'  => 'select2',
                'label' => 'Brand',
            ],
            function () {
                $brands = [];
                foreach (Brand::all() as $item) {
                    $brands[$item->id] = $item->name;
                }
                return $brands;
            },
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'brand_id', '=', $value);
            }
        );
        CRUD::addFilter(
            [
                'name'  => 'product_model_id',
                'type'  => 'select2',
                'label' => 'Product Model',
            ],
            function () {
                $productModels = [];
                foreach (ProductModel::all() as $item) {
                    $productModels[$item->id] = $item->name;
                }
                return $productModels;
            },
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'product_model_id', '=', $value);
            }
        );

        CRUD::column('name');
        CRUD::column('product_code');
        CRUD::column('selling_price');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        CRUD::addField([
            'label'     => 'Category',
            'type'      => 'select2',
            'name'      => 'category_id', // the db column for the foreign key
            'entity'    => 'category', // the method that defines the relationship in your Model
            'model'     => 'App\Models\Category', // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
        ]);

        CRUD::field('name');

        CRUD::field('product_code');

        CRUD::addField([
            'name'  => 'description',
            'label' => 'Description',
            'type'  => 'ckeditor',
        ]);

        CRUD::field('selling_price');

        CRUD::addField([
            'name'   => 'images',
            'label'  => 'Images',
            'type'   => 'upload_multiple',
            'upload' => true,
        ], 'both');

        CRUD::addField([
            'label'     => 'Brand',
            'type'      => 'select2',
            'name'      => 'brand_id', // the db column for the foreign key
            'entity'    => 'brand', // the method that defines the relationship in your Model
            'model'     => 'App\Models\Brand', // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
        ]);

        CRUD::addField([
            'label'     => 'Product Model',
            'type'      => 'select2',
            'name'      => 'product_model_id', // the db column for the foreign key
            'entity'    => 'productModel', // the method that defines the relationship in your Model
            'model'     => 'App\Models\ProductModel', // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
        ]);

        //dd(request()->all());

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        CRUD::addColumn([
            'name'  => 'category_id',
            'label' => 'Category',
        ]);
        CRUD::addColumn([
            'name'  => 'name',
            'label' => 'Name'
        ]);
        CRUD::addColumn([
            'name'  => 'product_code',
            'label' => 'Product Code'
        ]);
        CRUD::addColumn([
            'name'     => 'description',
            'label'    => 'Description',
            'type'     => 'closure',
            'function' => function ($model) {
                return $model->description;
            }
        ]);
        CRUD::addColumn([
            'name'  => 'selling_price',
            'label' => 'Selling Price',
        ]);
        CRUD::addColumn([
            'name'     => 'images',
            'label'    => 'Images',
            'type'     => 'closure',
            'function' => function ($model) {
                if (!empty($model->images) && count($model->images) > 0) {
                    $html = '';
                    foreach ($model->images as $image) {
                        $html .= '<img src="' . $image . '" class="m-2" style="width: 300px; border-radius: 3px;">';
                    }
                    return $html;
                }
                return "-";
            }
        ]);
        CRUD::addColumn([
            'name'  => 'brand_id',
            'label' => 'Brand',
        ]);
        CRUD::addColumn([
            'name'     => 'product_model_id',
            'label'    => 'Product Model',
            'type'     => 'closure',
            'function' => function ($model) {
                return ProductModel::find($model->product_model_id)->name;
            }
        ]);
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        if (!empty(OrderDetail::where('product_id', $id)->first())) {
            return response()->json([
                'success' => false,
                'message' => 'Can\'t delete product. Product is ordered by a customer.',
            ]);
        }

        return $this->crud->delete($id);
    }
}
