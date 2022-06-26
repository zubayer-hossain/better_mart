<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TeamRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TeamCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TeamCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Team::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/team');
        CRUD::setEntityNameStrings('team', 'teams');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('designation');
        CRUD::column('department');
        CRUD::column('mobile');
        CRUD::column('email');

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
        CRUD::setValidation(TeamRequest::class);

        CRUD::field('name');
        CRUD::field('designation');
        CRUD::field('department');
        CRUD::field('mobile');
        CRUD::field('email');
        CRUD::addField([
            'name'         => 'image',
            'label'        => 'Image',
            'type'         => 'image',
            'crop'         => false,
            'aspect_ratio' => 1
        ]);
        CRUD::addField([
            'name'         => 'vcard',
            'label'        => 'Visiting Card',
            'type'         => 'image',
            'crop'         => false,
            'aspect_ratio' => 1
        ]);

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
            'name'  => 'name',
            'label' => 'Name'
        ]);
        CRUD::addColumn([
            'name'  => 'designation',
            'label' => 'Designation'
        ]);
        CRUD::addColumn([
            'name'  => 'department',
            'label' => 'Department',
        ]);
        CRUD::addColumn([
            'name'  => 'mobile',
            'label' => 'Mobile',
        ]);
        CRUD::addColumn([
            'name'  => 'email',
            'label' => 'Email',
        ]);
        CRUD::addColumn([
            'name'   => 'image',
            'type'   => 'image',
            'width'  => '300px',
            'height' => 'auto'
        ]);
        CRUD::addColumn([
            'name'   => 'vcard',
            'label' => 'Visiting Card',
            'type'   => 'image',
            'width'  => '400px',
            'height' => 'auto'
        ]);
    }
}
