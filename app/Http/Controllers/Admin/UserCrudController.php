<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if (backpack_auth()->user()->id === 1) {
            CRUD::addFilter(
                [
                    'name'  => 'role_id',
                    'type'  => 'select2',
                    'label' => 'Role',
                ],
                function () {
                    $roles = [];
                    foreach (Role::all() as $role) {
                        $roles[$role->id] = $role->name;
                    }
                    return $roles;
                },
                function ($value) {
                    // if the filter is active
                    $this->crud->addClause('where', 'role_id', '=', $value);
                }
            );
        }

        CRUD::addColumn([
            'name'  => 'role_id',
            'label' => 'Role',
        ]);
        CRUD::column('name');
        CRUD::column('email');

        $this->crud->addClause('where', 'role_id', '!=', NULL);
        if (backpack_auth()->user()->id !== 1) {
            $this->crud->addClause('where', 'id', '!=', 1);
        }

        if (backpack_auth()->user()->id !== 1) {
            CRUD::removeButton('delete');
        }

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
        CRUD::setValidation(UserRequest::class);
        CRUD::addField([
            'label'     => 'Role',
            'type'      => 'select2',
            'name'      => 'role_id', // the db column for the foreign key
            'entity'    => 'role', // the method that defines the relationship in your Model
            'model'     => 'App\Models\Role', // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
        ]);
        CRUD::field('name');
        CRUD::field('email');
        CRUD::field('password');
        CRUD::addField([
            'name'         => 'image',
            'label'        => 'Image',
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
        $this->crud->removeField('email');
    }

    public function store(UserRequest $request)
    {
        $response = $this->traitStore($request);

        User::where('email', $request->email)->update([
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return $response;
    }

    public function update(UserRequest $request)
    {
        $userData = User::find($request->id);

        $response = $this->traitUpdate($request);

        if (!empty($request->password)) {
            User::whereId($request->id)->update([
                'password' => Hash::make($request->password),
            ]);
        } else {
            User::whereId($request->id)->update([
                'password' => $userData->password,
            ]);
        }

        return $response;
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        CRUD::addColumn([
            'name'  => 'role_id',
            'label' => 'Role',
        ]);

        CRUD::addColumn([
            'name' => 'name',
        ]);
        CRUD::addColumn([
            'name' => 'email',
        ]);
        CRUD::addColumn([
            'name'   => 'image',
            'type'   => 'image',
            'width'  => '300px',
            'height' => 'auto'
        ]);

        if (backpack_auth()->user()->id !== 1) {
            CRUD::removeButton('delete');
        }
    }

}
