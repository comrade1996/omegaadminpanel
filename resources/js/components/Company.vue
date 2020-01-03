<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">الشركات</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="openCreateModal">شركة جديدة <i class="fas fa-Category-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>المعرف</th>
                                <th>الاسم</th>
                                <th>الوصف</th>
                                <th>تاريخ الانشاء</th>
                                <th>تاريخ التعديل</th>
                                <th>اسم المنشئ</th>
                            </tr>
                            <tr v-for="company in companys.data" :key="company.id">
                                <td>{{company.id}}</td>
                                <td>{{company.name | capitalize}}</td>
                                <td>{{company.description | capitalize}}</td>
                                <td>{{company.created_at | readableDate }}</td>
                                <td>{{company.updated_at | readableDate }}</td>
                                <td>{{company.created_by}}</td>
                                <td>
                                    <a href="#" @click="openEditModal(company)">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteCompany(company.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="companys"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createCompany" tabindex="-1" role="dialog" aria-labelledby="createCompanyTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCompanyTitle">شركة جديدة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateCompany() : createCompany()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>الاسم</label>
                            <input v-model="form.name" type="text" name="name"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label>الوصف</label>
                            <input v-model="form.description" type="text" name="description"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                            <has-error :form="form" field="description"></has-error>
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
        data()
        {

            return{
                editmode:true,
                companys:{},
                form:new Form({
                    // id:'',
                    name:'',
                    description:''
                })
            }
        },
        methods:
            {
                getResults(page = 1) {
                    axios.get('api/company?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });},
                openCreateModal()
                {
                    this.editmode=false;

                    this.form.clear();
                    this.form.reset();
                    $('#createCompany').modal('show');
                },
                openEditModal(Company)
                {
                    this.editmode=true;
                    this.form.clear();
                    this.form.reset();
                    $('#createCompany').modal('show');
                    this.form.fill(Company);
                },
                getCompanys()
                {
                    axios.get("api/company").then(({data}) => (this.companys =data));
                },
                createCompany()
                {

                    this.form.post('api/company')
                        .then(()=>{
                            this.$Progress.start();
                            Fire.$emit('afterCreate');
                            $('#createCompany').modal('hide')
                            toast.fire({
                                type: 'success',
                                title: 'تم الانشاء بنجاح'
                            })
                            this.$Progress.finish();

                        })
                        .catch(()=>{

                        })
                  },
                updateCompany()
                {
                   // this.$progress.start();
                    console.log("hoola");
                    this.form.put('api/company/'+this.form.id)
                        .then(()=>
                        {
                            swal.fire(
                                'تم التعديل',
                                'تم التعديل بنجاح',
                                'success'
                            )
                           // this.$progress.finish();
                            $('#createCompany').modal('hide');
                            Fire.$emit('afterCreate');
                        })
                        .catch(()=>
                        {
                          //  this.$Progress.fail();
                        })
                },
                deleteCompany(id)
                {
                    swal.fire({
                        title: 'مسح شركة',
                        text: "هل انت متأكد؟",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if(result.value) {
                            this.form.delete('api/company/' + id)
                                .then(() => {
                                    swal.fire(
                                        ' تم المسح ',
                                        'تم المسح بنجاح',
                                        'success'
                                    )
                                    Fire.$emit('afterCreate');
                                })
                                .catch(() => {
                                    swal.fire(
                                        'فشل',
                                        'حدث خطأ حاول مرة اخرى',
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
                axios.get('api/findCompany?q='+query)
                    .then((data)=>{
                        this.companys = data.data
                    })
                    .catch(()=>{})
            });
            this.getCompanys();
            Fire.$on('afterCreate',()=>{this.getCompanys()});
            //setInterval(()=>this.getUnits(), 3000);

        }
    }
</script>
