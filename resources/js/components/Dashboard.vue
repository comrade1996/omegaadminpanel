<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">الرئيسية</h3>
                        <div class="card-tools">

                            <form @submit.prevent="dateFilter(startdate,enddate)">
                                تاريخ البداية<input type="date" data-provide="datepicker" name="startdate"
                                                    v-model="startdate" required>
                                تاريخ النهاية
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
                                <th>مجموع المبيعات</th>
                                <th>مجموع المنصرفات</th>
                                <th> صافي الربح</th>
                                <th>الكمية</th>
                                <th>عدد عمليات البيع</th>

                            </tr>
                            </thead>
                                <tbody >
                            <tr>
                                <td>{{this.totalSales}}</td>
                                <td>{{this.totalExpenses}}</td>
                                <td>{{this.totalSales - this.totalExpenses}}</td>
                                <td>{{this.quantity}}</td>
                                <td>{{this.salesCounter}}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->

            </div>
        </div>
        <div class="row col-md-12">
            <GChart
                type="ColumnChart"
                :data="chartData"
                :options="chartOptions"
            />
            <GChart
                type="PieChart"
                :data="datas"
                :options="options"
            />
        </div>
    </div>
</template>

<script>
    export default {
        data() {

            return {

                chartData: [],
                chartOptions: {
                    chart: {
                        title: 'Pharmacy Performance By months',
                        subtitle: 'Sales, Expenses, and Profit in A year',
                    }
                }, datas: [], options: {
                    title: 'Sales Per Product',
                    is3D: true,
                },
                tempProducts: [],
                salesDetails: [],
                sales: [],
                expenses: [],
                totalSales:0,
                totalExpenses:0,
                netProfit:0,
                quantity:0,
                salesCounter: 0,
                startdate: '',
                enddate: ''
            }
        },
        methods:
            {

                caluclateProductsReport() {
                    this.datas = [];
                    this.datas.push(['Sales', 'Sales per Product']);
                    this.salesDetails.forEach(element => {

                        if (!this.tempProducts.includes(element.product.name)) {
                            this.tempProducts.push(element.product.name);
                        }
                    });


                    this.tempProducts.forEach(element => {
                        var tempcounter = 0;
                        var pr = element;
                        this.salesDetails.forEach(element => {

                            if (pr == element.product.name) {
                                tempcounter = tempcounter + element.quantity;
                            }
                        });

                        this.datas.push([element, tempcounter]);
                    });


                    console.log("total saless names")
                    console.log(this.tempProducts)
                },
                caluclateMonthlyReport() {
                    this.chartData = [];
                    this.chartData.push(['Month', 'Sales', 'Expenses', 'Profit']);
                    var dates = [];
                    this.sales.forEach(element => {

                        if (!dates.includes(element.created_at.substring(5, 7))) {
                            dates.push(element.created_at.substring(5, 7));
                        }
                    });


                    dates.forEach(element => {
                        var tempSalesCounter = 0;
                        var tempExpensesCounter = 0;
                        var date = element;
                        var tempProfit = 0;
                        this.sales.forEach(element => {

                            if (date == element.updated_at.substring(5, 7)) {
                                tempSalesCounter = tempSalesCounter + Number(element.grandtotal);

                            }
                        });

                        this.expenses.forEach(element => {

                            if (date == element.updated_at.substring(5, 7)) {
                                tempExpensesCounter = tempExpensesCounter + Number(element.amount);
                            }
                        });
                        tempProfit = tempSalesCounter - tempExpensesCounter;
                        this.chartData.push([date, Number(tempSalesCounter), Number(tempExpensesCounter), Number(tempProfit)]);
                    });


                    console.log("total saless dates")
                    console.log(this.chartData)
                },
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
                                this.claluateExpenses(),
                                this.claluateQuantity(),
                                this.claluatetotalSale(),
                                this.caluclateProductsReport(),
                                this.caluclateMonthlyReport()
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
                    this.salesCounter = 0;
                    this.sales.forEach(element => {
                            console.log("total salesssssss")
                    console.log(element)
                    if(element.verified==1){
                        this.salesCounter++;
                        this.totalSales = this.totalSales+element.grandtotal
                    }
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
                    if(element.verified==1){
                        this.quantity = this.quantity+element.quantity
                    }
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
                          this.claluatetotalSale(),
                          this.caluclateProductsReport(),
                          this.caluclateMonthlyReport()

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

            setTimeout(() => this.getSalesDetails(), 200);

        }
    }

</script>
