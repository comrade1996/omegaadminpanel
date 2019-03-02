<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales Details Table</h3>
                        <div class="card-tools">

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
                            <tr v-for="saledetail in salesDetails.data" :key="saledetail.id">
                                <td>{{saledetail.id}}</td>
                                <td>{{saledetail.sale_id | capitalize}}</td>
                                <td>{{saledetail.product.name | capitalize}}</td>
                                <td>{{saledetail.product.quantity | capitalize}}</td>
                                <td>{{saledetail.created_at | readableDate }}</td>
                                <td>{{saledetail.updated_at | readableDate }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="salesDetails"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
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
                editmode: true,
                salesDetails: {}
            }
        },
        methods:
            {
                getResults(page = 1) {
                    axios.get('api/salesdetails?page=' + page)
                        .then(response => {
                            this.salesDetails = response.data;
                        });},
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
