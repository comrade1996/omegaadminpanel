<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales Details Table</h3>
                        <div class="card-tools">
                            <form @submit.prevent="dateFilter(startdate,enddate)">
                                Start Date<input type="date" data-provide="datepicker" name="startdate" v-model="startdate" required>
                                    End Date
                                    <input type="date" name="enddate" v-model="enddate" required>

                                <button type="submit" class="btn btn-primary">search</button>
                                <button onclick="getSalesDetails()" class="btn btn-primary">all</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Sale Invoice</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            <tr  v-for="saledetail in salesDetails">
                                <td>{{saledetail.id}}</td>
                                <td>{{saledetail.sale_id | capitalize}}</td>
                                <td>{{saledetail.product_id }}</td>
                                <td>{{saledetail.quantity}}</td>
                                <td>{{saledetail.created_at | readableDate }}</td>
                                <td>{{saledetail.updated_at | readableDate }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {

            return {
                salesDetails: {},
                    startdate:'',
                enddate:''
            }
        },
        methods:
            {
                dateFilter(startdate,enddate)
                {
                    console.log("original data")
                    console.log(this.salesDetails)

                    axios.post('api/filtersalesdetails/' ,{
                        startdate:startdate,
                        enddate:enddate
                    })
                        .then((data) => {
                            console.log("resonse data")
                            console.log(data)
                            this.salesDetails=data.data
                        })
                        .catch((response) => {
                         console.log(response)
                        })
                },
                getSalesDetails() {
                    axios.get("api/salesdetails").then(({data}) => (this.salesDetails = data.data));
                    console.log(this.salesDetails)
                }
            },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            Fire.$on('searching', () => {
                let query =this.$parent.search;
                axios.get('api/findsalesdetails?q='+query)
                    .then((data)=>{
                        this.salesDetails = data.data
                    })
                    .catch(()=>{})
            });
            this.getSalesDetails();
            Fire.$on('afterCreate', () => {
                this.getSalesDetails()
            });
            // setInterval(()=>this.getExpensesCategories(), 3000);

        }
    }
</script>
