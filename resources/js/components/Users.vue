<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="openCreateModal"> New User <i
                                class="fas fa-user-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="user in users.data" :key="user.id">
                                <td>{{user.id}}</td>
                                <td>{{user.name | capitalize}}</td>
                                <td>{{user.email | capitalize}}</td>
                                <td>{{user.type | capitalize}}</td>
                                <td>{{user.created_at | readableDate }}</td>
                                <td>
                                    <a href="#" @click="openEditModal(user)">
                                        <i class="fas fa-user-edit text-blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteUser(user.id)">
                                        <i class="fas fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="users"
                        @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserTitle">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="text" name="email"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Role</label>
                                <select v-model="form.type" name="type" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select Role for User</option>
                                    <option v-for="item in items" :value="item.id">
                                        {{ item.label }}
                                    </option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Bio</label>
                                <textarea v-model="form.bio" name="bio"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                                </textarea>
                                <has-error :form="form" field="bio"></has-error>
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
                users: {},
                items: [
                    {id: 1, label: 'Admin'},
                    {id: 0, label: 'User'}
                ],
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods:
            {
                getResults(page = 1) {
                    axios.get('api/user?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });},

                openCreateModal() {
                    this.editmode = false;

                    this.form.clear();
                    this.form.reset();
                    $('#createUser').modal('show');
                },
                openEditModal(user) {
                    this.editmode = true;
                    this.form.clear();
                    this.form.reset();
                    $('#createUser').modal('show');
                    this.form.fill(user);
                },
                getUsers() {
                    axios.get("api/user").then(({data}) => (this.users = data));
                },
                createUser() {

                    this.form.post('api/user')
                        .then(() => {
                            this.$Progress.start();
                            Fire.$emit('afterCreate');
                            $('#createUser').modal('hide');
                            toast.fire({
                                type: 'success',
                                title: 'User Created successfully'
                            });
                            this.$Progress.finish();
                        })
                        .catch(() => {

                        })
                },
                updateUser() {
                    // this.$progress.start();
                    console.log("hoola");
                    this.form.put('api/user/' + this.form.id)
                        .then(() => {
                            swal.fire(
                                'Updated!',
                                'Your user has been updated.',
                                'success'
                            )
                            // this.$progress.finish();
                            $('#createUser').modal('hide');
                            Fire.$emit('afterCreate');
                        })
                        .catch(() => {
                            //  this.$Progress.fail();
                        })
                },
                deleteUser(id) {
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
                            this.form.delete('api/user/' + id)
                                .then(() => {
                                    swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    );
                                    Fire.$emit('afterCreate');
                                })
                                .catch(() => {
                                    swal.fire(
                                        'Failed!',
                                        'Your file has been Filed.',
                                        'warning'
                                    )
                                });
                        }
                    })

                }
            },
        mounted() {
            console.log('Component mounted.');
        },
        created() {
            Fire.$on('searching', () => {
                let query =this.$parent.search;
                axios.get('api/findUser?q='+query)
                    .then((data)=>{
                        this.users = data.data
                    })
                    .catch(()=>{})
            });
            this.getUsers();
            Fire.$on('afterCreate', () => {
                this.getUsers();
            });
            //setInterval(()=>this.getUsers(), 3000);

        }
    }
</script>
