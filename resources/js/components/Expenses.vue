<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Expenses Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="openCreateModal"> New Expenses <i class="fas fa-expenses-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Modify</th>
                                <th>created by</th>
                                <th>Options</th>
                            </tr>
                            <tr v-for="expenses in expensess.data" :key="expenses.id">
                                <td>{{expenses.id}}</td>
                                <td>{{expenses.expensescategory.name | capitalize}}</td>
                                <td>{{expenses.amount}}</td>
                                <td>{{expenses.created_at | readableDate }}</td>
                                <td>{{expenses.updated_at | readableDate }}</td>
                                <td>{{expenses.created_by}}</td>
                                <td>
                                    <a href="#" @click="openEditModal(expenses)">
                                        <i class="fas fa-pencil-alt text-blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexpenses(expenses.id)">
                                        <i class="fas fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="expensess"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createexpenses" tabindex="-1" role="dialog" aria-labelledby="createexpensesTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createexpensesTitle">Create expenses</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateexpenses() : createexpenses()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Category</label>
                                <select v-model="form.category" name="category" class="form-control" :class="{ 'is-invalid': form.errors.has('category') }">
                                    <option value="">Select Category for expenses</option>
                                    <option v-for="category in categories" :value="category.id">
                                        {{ category.name | capitalize}}
                                    </option>
                                </select>
                                <has-error :form="form" field="category"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Amount</label>
                                <input v-model="form.amount" type="text" name="amonut"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                                <has-error :form="form" field="amount"></has-error>
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
        data()
        {

            return{
                editmode:true,
                expensess:{},
                categories: [{}],
                form:new Form({
                    id:'',
                    amount:'',
                    category:''
                })
            }
        },
        methods:
            {
                getResults(page = 1) {
                    axios.get('api/expenses?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });},
                openCreateModal()
                {
                    this.editmode=false;

                    this.form.clear();
                    this.form.reset();
                    $('#createexpenses').modal('show');
                },
                openEditModal(expenses)
                {
                    this.editmode=true;
                    this.form.clear();
                    this.form.reset();
                    $('#createexpenses').modal('show');
                    this.form.fill(expenses);
                },
                getexpensess()
                {
                    axios.get("api/expenses").then(({data}) => (this.expensess =data));
                },
                getCategories()
                {
                    axios.get("api/expensescategory").then(({data}) => (this.categories =data.data));
                },
                createexpenses()
                {

                    this.form.post('api/expenses')
                        .then(()=>{
                            this.$Progress.start();
                            Fire.$emit('afterCreate');
                            $('#createexpenses').modal('hide')
                            toast.fire({
                                type: 'success',
                                title: 'expenses Created successfully'
                            })
                            this.$Progress.finish();

                        })
                        .catch(()=>{

                        })
                },
                updateexpenses()
                {
                    // this.$progress.start();
                    console.log("hoola");
                    this.form.put('api/expenses/'+this.form.id)
                        .then(()=>
                        {
                            swal.fire(
                                'Updated!',
                                'Your expenses has been updated.',
                                'success'
                            )
                            // this.$progress.finish();
                            $('#createexpenses').modal('hide');
                            Fire.$emit('afterCreate');
                        })
                        .catch(()=>
                        {
                            //  this.$Progress.fail();
                        })
                },
                deleteexpenses(id)
                {
                    swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if(result.value) {
                            this.form.delete('api/expenses/' + id)
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
                axios.get('api/findExpenses?q='+query)
                    .then((data)=>{
                        this.expensess = data.data
                    })
                    .catch(()=>{})
            });
            this.getexpensess();
            Fire.$on('afterCreate',()=>{this.getexpensess()});
            this.getCategories();
            Fire.$on('afterCreate',()=>{this.getCategories()});
            console.log(this.categories)
            //setInterval(()=>this.getexpensess(), 3000);

        }
    }
</script>
