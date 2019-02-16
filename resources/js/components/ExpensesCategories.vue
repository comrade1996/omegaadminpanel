<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Expenses Categories Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="openCreateModal"> New Category <i
                                class="fas fa-Category-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="category in ExpensesCategories.data" :key="category.id">
                                <td>{{category.id}}</td>
                                <td>{{category.name | capitalize}}</td>
                                <td>{{category.description | capitalize}}</td>
                                <td>{{category.created_at | readableDate }}</td>
                                <td>{{category.updated_at | readableDate }}</td>
                                <td>
                                    <a href="#" @click="openEditModal(category)">
                                        <i class="fas fa-pencil-alt text-blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteCategory(category.id)">
                                        <i class="fas fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="ExpensesCategories"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="createCategoryTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCategoryTitle">Create Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateCategory() : createCategory()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <input v-model="form.description" type="text" name="description"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                <has-error :form="form" field="description"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {

            return {
                editmode: true,
                ExpensesCategories: {},
                form: new Form({
                    id: '',
                    name: '',
                    description: ''
                })
            }
        },
        methods:
            {
                getResults(page = 1) {
                    axios.get('api/expensescategory?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });},
                openCreateModal() {
                    this.editmode = false;

                    this.form.clear();
                    this.form.reset();
                    $('#createCategory').modal('show');
                },
                openEditModal(Category) {
                    this.editmode = true;
                    this.form.clear();
                    this.form.reset();
                    $('#createCategory').modal('show');
                    this.form.fill(Category);
                },
                getExpensesCategories() {
                    axios.get("api/expensescategory").then(({data}) => (this.ExpensesCategories = data));
                },
                createCategory() {

                    this.form.post('api/expensescategory')
                        .then(() => {
                            this.$Progress.start();
                            Fire.$emit('afterCreate');
                            $('#createCategory').modal('hide')
                            toast.fire({
                                type: 'success',
                                title: 'Category Created successfully'
                            });
                            this.$Progress.finish();

                        })
                        .catch(() => {

                        })
                },
                updateCategory() {
                    // this.$progress.start();

                    console.log(this.form.id)
                    console.log(this.form.description)
                    console.log("hoola");
                    this.form.put('api/expensescategory/' + this.form.id)
                        .then(() => {
                            swal.fire(
                                'Updated!',
                                'Your Category has been updated.',
                                'success'
                            )
                            // this.$progress.finish();
                            $('#createCategory').modal('hide');
                            Fire.$emit('afterCreate');
                        })
                        .catch(() => {
                            //  this.$Progress.fail();
                        })
                },
                deleteCategory(id) {
                    swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            this.form.delete('api/expensescategory/' + id)
                                .then(() => {
                                    swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                    Fire.$emit('afterCreate');
                                })
                                .catch(() => {
                                    swal.fire(
                                        'Failed!',
                                        'Your file has been Filed.',
                                        'warning'
                                    )
                                })
                        }
                    })

                }
            },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            Fire.$on('searching', () => {
                let query =this.$parent.search;
                axios.get('api/findExpensesCategory?q='+query)
                    .then((data)=>{
                        this.ExpensesCategories = data.data
                    })
                    .catch(()=>{})
            });
            this.getExpensesCategories();
            Fire.$on('afterCreate', () => {
                this.getExpensesCategories()
            });
            // setInterval(()=>this.getExpensesCategories(), 3000);

        }
    }
</script>
