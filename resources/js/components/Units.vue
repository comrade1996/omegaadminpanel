<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Units Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="openCreateModal"> New unit <i class="fas fa-Category-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Modify</th>
                                <th>Created Py</th>
                            </tr>
                            <tr v-for="unit in units.data" :key="unit.id">
                                <td>{{unit.id}}</td>
                                <td>{{unit.name | capitalize}}</td>
                                <td>{{unit.created_at | readableDate }}</td>
                                <td>{{unit.updated_at | readableDate }}</td>
                                <td>{{unit.created_by}}</td>
                                <td>
                                    <a href="#" @click="openEditModal(unit)">
                                        <i class="fas fa-pencil-alt text-blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteUnit(unit.id)">
                                        <i class="fas fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="units"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="createUnit" tabindex="-1" role="dialog" aria-labelledby="createUnitTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUnitTitle">Create Unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUnit() : createUnit()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
<!--
                        <div class="form-group">
                            <label>Description</label>
                            <input v-model="form.description" type="text" name="description"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                            <has-error :form="form" field="description"></has-error>
                        </div> -->

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
                units:{},
                form:new Form({
                    id:'',
                    name:''
                    // description:''
                })
            }
        },
        methods:
            {
                getResults(page = 1) {
                    axios.get('api/unit?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });},
                openCreateModal()
                {
                    this.editmode=false;

                    this.form.clear();
                    this.form.reset();
                    $('#createUnit').modal('show');
                },
                openEditModal(Unit)
                {
                    this.editmode=true;
                    this.form.clear();
                    this.form.reset();
                    $('#createUnit').modal('show');
                    this.form.fill(Unit);
                },
                getUnits()
                {
                    axios.get("api/unit").then(({data}) => (this.units =data));
                },
                createUnit()
                {

                    this.form.post('api/unit')
                        .then(()=>{
                            this.$Progress.start();
                            Fire.$emit('afterCreate');
                            $('#createUnit').modal('hide')
                            toast.fire({
                                type: 'success',
                                title: 'Unit Created successfully'
                            })
                            this.$Progress.finish();

                        })
                        .catch(()=>{

                        })
                  },
                updateUnit()
                {
                   // this.$progress.start();
                    console.log("hoola");
                    this.form.put('api/unit/'+this.form.id)
                        .then(()=>
                        {
                            swal.fire(
                                'Updated!',
                                'Your Unit has been updated.',
                                'success'
                            )
                           // this.$progress.finish();
                            $('#createUnit').modal('hide');
                            Fire.$emit('afterCreate');
                        })
                        .catch(()=>
                        {
                          //  this.$Progress.fail();
                        })
                },
                deleteUnit(id)
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
                            this.form.delete('api/unit/' + id)
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
                axios.get('api/findUnit?q='+query)
                    .then((data)=>{
                        this.units = data.data
                    })
                    .catch(()=>{})
            });
            this.getUnits();
            Fire.$on('afterCreate',()=>{this.getUnits()});
            //setInterval(()=>this.getUnits(), 3000);

        }
    }
</script>
