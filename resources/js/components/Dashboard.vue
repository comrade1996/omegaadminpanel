<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dashboard Table</h3>
                        <div class="card-tools">

                            <form @submit.prevent="dateFilter(startdate,enddate)">
                                Start Date<input type="date" data-provide="datepicker" name="startdate"
                                                 v-model="startdate" required>
                                End Date
                                <input type="date" name="enddate" v-model="enddate" required>

                                <button type="submit" class="btn btn-primary">search</button>
                                <button type="button" @click="getSalesDetails" class="btn btn-primary">all</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                            <thead>
                            <tr>
                                <th >Total Sales</th>
                                <th >Total Expenses</th>
                                <th > Net Profit</th>
                                <th >Quantity</th>

                            </tr>
                            </thead>
                                <tbody >
                            <tr>
                                <td>{{this.totalSales}}</td>
                                <td>{{this.totalExpenses}}</td>
                                <td>{{this.totalSales - this.totalExpenses}}</td>
                                <td>{{this.quantity}}</td>
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

                salesDetails: [],
                sales: [],
                expenses: [],
                totalSales:0,
                totalExpenses:0,
                netProfit:0,
                quantity:0,
                startdate: '',
                enddate: ''
            }
        },
        methods:
            {
                dateFilter(startdate, enddate) {
                    console.log("original data")
                    console.log(this.salesDetails)

                    axios.post('api/filtersalesdetails/', {
                        startdate: startdate,
                        enddate: enddate
                    })
                        .then((data) => {
                            console.log("resonse data")
                            console.log(data)
                            this.salesDetails = data.data,
                            this.claluateExpenses,
                    this.claluateQuantity,
                    this.claluatetotalSale
                        })
                        .catch((response) => {
                            console.log(response)
                        })


                  axios.post('api/filterexpenses/', {
                        startdate: startdate,
                        enddate: enddate
                    })
                        .then((data) => {
                            console.log("resonse data")
                            console.log(data)
                            this.expenses = data.data
                        })
                        .catch((response) => {
                            console.log(response)
                        })



                        axios.post('api/filtersales/', {
                        startdate: startdate,
                        enddate: enddate
                    })
                        .then((data) => {
                            console.log("resonse data")
                            console.log(data)
                            this.sales = data.data
                        })
                        .catch((response) => {
                            console.log(response)
                        })
                },
                claluatetotalSale()
                {

                    this.totalSales=0;
                    this.sales.forEach(element => {
                            console.log("total salesssssss")
                    console.log(element)
                        this.totalSales = this.totalSales+element.grandtotal
                    });

                },
                claluateExpenses()
                {

                    this.totalExpenses=0;
                    this.expenses.forEach(element => {
                        this.totalExpenses = this.totalExpenses+Number(element.amount)
                    });
                },
                claluateQuantity()
                {

                    this.quantity=0;
                    this.salesDetails.forEach(element => {
                        this.quantity = this.quantity+element.quantity
                    });
                },
                getSalesDetails() {
                    this.startdate = ''
                    this.enddate = ''
                    axios.get("api/salesdetails").then(({data}) => (this.salesDetails = data.data,console.log(data.data)));
                    axios.get("api/sales").then(({data}) => (this.sales = data.data));
                    axios.get("api/expenses").then(({data}) => (this.expenses = data.data));
                    console.log(this.salesDetails)
                    console.log(this.sales)
                    console.log(this.expenses)
                      this.claluateExpenses(),
                    this.claluateQuantity(),
                    this.claluatetotalSale()
                }
            },
     mounted() {
            console.log('Component mounted.')
         this.getSalesDetails()

        },
        created() {
                this.getSalesDetails()

            Fire.$on('searching', () => {
                let query = this.$parent.search;
                axios.get('api/findSaleDetail?q=' + query)
                    .then((data) => {
                        this.salesDetails = data.data.data;
                        console.log(this.salesDetails)
                    })
                    .catch(() => {
                    })
            });

            Fire.$on('afterCreate', () => {
         this.getSalesDetails()

            });
         this.getSalesDetails()

            // setInterval(()=>this.getExpensesCategories(), 3000);

        }
    }

</script>
