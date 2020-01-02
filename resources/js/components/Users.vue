<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">المستخدمين</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="openCreateModal"> انشاء مستخدم <i
                                class="fas fa-user-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>المعرف</th>
                                <th>الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>نوع المستخدم</th>
                                <th>تاريخ الانشاء</th>
                                <th>تاريخ التعديل</th>
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
                                        <i class="fa fa-trash text-red"></i>
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
                        <h5 class="modal-title" id="createUserTitle">انشاء مستخدم</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>الاسم</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>البريد الالكتروني</label>
                                <input v-model="form.email" type="text" name="email"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <label>كلمة المرور</label>
                                <input v-model="form.password" type="password" name="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <div class="form-group">
                                <label>نوع المستخدم</label>
                                <select v-model="form.type" name="type" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">اختر نوع المستخدم</option>
                                    <option v-for="item in items" :value="item.id">
                                        {{ item.label }}
                                    </option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>

                            <div class="form-group">
                                <label>معلومات اضافية</label>
                                <textarea v-model="form.bio" name="bio"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                                </textarea>
                                <has-error :form="form" field="bio"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-primary">حفظ</button>
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
                    {id: 2, label: 'Cashier'},
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
                                title: 'تم اﻹنشاء بنجاح'
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
                                'تم التعديل',
                                'تم التعديل بنجاح',
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
                        title: 'هل انت متأكد؟',
                        text: "لن تستطيع التراجع",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'امسح!'
                    }).then((result) => {
                        if (result.value) {
                            this.form.delete('api/user/' + id)
                                .then(() => {
                                    swal.fire(
                                        ' تم المسح ',
                                        'لقد تم المسح بنجاح.',
                                        'success'
                                    );
                                    Fire.$emit('afterCreate');
                                })
                                .catch(() => {
                                    swal.fire(
                                        'فشل',
                                        '  تم المسح بنجاح.',
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
