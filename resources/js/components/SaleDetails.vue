<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">تفاصيل المبيعات</h3>
                        <input placeholder="Search by Invoice ID" class="form-control" v-model="filters.sale_id.value"/>
                        <input placeholder="Search by Product Name" class="form-control" style="margin-top: 10px;" v-model="filters.name.value"/>
                        <input placeholder="Search by Company Name" class="form-control" style="margin-top: 10px;"
                               v-model="filters.company.value"/>
                        <div class="card-tools">

                            <form @submit.prevent="dateFilter(startdate,enddate)" style="margin-top: 10px;">
                                تاريخ البداية<input type="date" data-provide="datepicker" name="startdate"
                                                    v-model="startdate" required>
                                تاريخ النهاية
                                <input type="date" name="enddate" v-model="enddate" required>

                                <button type="submit" class="btn btn-primary">بحث</button>
                                <button type="button" @click="getSalesDetails" class="btn btn-primary">الكل</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="margin-top: 10px;">
                            <v-table :data="salesDetails"  :filters="filters"
                                     class="table table-hover">
                            <thead slot="head">
                            <tr>
                                <v-th sortKey="id">المعرف</v-th>
                                <v-th sortKey="sale_id">رقم الفاتورة</v-th>
                                <v-th sortKey="product.name">اسم المنتج</v-th>
                                <v-th sortKey="product.company.name">اسم الشركة</v-th>
                                <v-th sortKey="quantity">الكمية</v-th>
                                <v-th sortKey="created_at">تاريخ الانشاء</v-th>
                                <v-th sortKey="updated_at">تاريخ التعديل</v-th>
                                <v-th>اسم المنشئ</v-th>
                                <!-- <v-th>حالة الفاتورة</v-th> -->
                            </tr>
                            </thead>
                                <tbody slot="body" slot-scope="{displayData}">
                            <v-tr v-for="row in displayData" :key="row.guid">
                                <td v-if=" row.quantity>0 || null">{{ row.id}}</td>
                                <td v-if=" row.quantity>0 || null">{{ row.sale_id}}</td>
                                <td v-if=" row.quantity>0 || null">{{ row.product.name }}</td>
                                <td v-if=" row.quantity>0 || null">{{ row.product.company.name }}</td>
                                <td v-if=" row.quantity>0 || null">{{ row.quantity}}</td>
                                <td v-if=" row.quantity>0 || null">{{ row.created_at }}</td>
                                <td v-if=" row.quantity>0 || null">{{ row.updated_at }}</td>
                                <td v-if=" row.quantity>0 || null">{{ row.created_by }}</td>
                                <!-- <td><p v-if="row.verified==1">مصدقة</p>
                                    <p v-if="row.verified==0">غير مصدقة</p>
                                </td> -->
                            </v-tr>
                            </tbody>
                        </v-table>

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
                filters: {
                    sale_id: { value: '', keys: ['sale_id']},
                    name: {value: '', keys: ['product.name']},
                    company: {value: '', keys: ['product.company.name']}
                },
                salesDetails: [],
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
                            this.salesDetails = data.data
                        })
                        .catch((response) => {
                            console.log(response)
                        })
                },

                getSalesDetails() {
                    this.startdate = ''
                    this.enddate = ''
                    axios.get("api/salesdetails").then(({data}) => (this.salesDetails = data.data));
                    console.log(this.salesDetails)
                }
            },
     mounted() {
         this.getSalesDetails()
            console.log('Component mounted.')
        },
        created() {

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

            // setInterval(()=>this.getExpensesCategories(), 3000);

        }
    }

</script>
