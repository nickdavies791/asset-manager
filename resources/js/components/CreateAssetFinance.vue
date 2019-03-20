<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Accounting Start</label>
                    <input class="form-control" type="date" name="accounting_start" v-model="account_start">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Accounting End</label>
                    <input class="form-control" type="date" name="accounting_end" v-model="account_end">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Purchase Date</label>
                    <input class="form-control" type="date" name="purchase_date" v-model="purchase_date">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>End of Life</label>
                    <input class="form-control" type="date" name="end_of_life" v-model="lifetime_end_date">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Lifetime (Years)</label>
                    <input class="form-control" type="number" step="0.01" :value="getYears" disabled>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Purchase Cost</label>
            <input class="form-control" type="number" step="0.01" name="purchase_cost" v-model="cost">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Current Value</label>
                    <input class="form-control" type="number" step="0.01" name="current_value" v-model="costs.value">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Charges</label>
                    <input class="form-control" type="number" step="0.01" name="depreciation" :value="getDepreciationCharges" readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Net Book Value</label>
            <input class="form-control" type="number" step="0.01" name="net_book_value" :value="getNetBookValue" readonly>
        </div>
    </div>
</template>
<script>
    let moment = require('moment');

    export default {
        data() {
            return {
                cost: 0,
                account_start: '2018-09-01',
                account_end: '2019-09-01',
                purchase_date: '2019-05-01',
                lifetime_end_date: '2022-05-01',
                costs: {
                    value: 0,
                },
                deprec: {
                    charges: 0,
                }
            }
        },

        methods: {
            round(x) {
                return +(Math.round(x + "e+2")  + "e-2");
            },
        },

        computed: {
            getYears() {
                let start = moment(this.purchase_date);
                let end = moment(this.lifetime_end_date);
                let years = end.diff(start, 'years');

                return years;
            },

            getPercentage() {
                return this.round(1 / this.getYears);
            },

            getDepreciationCharges() {
                return this.deprec.charges = this.round(((this.costs.value * this.getPercentage) / 12) * this.getAccountingMonths);
            },

            getAccountingMonths() {
                let start = moment(this.purchase_date);
                let end = moment(this.account_end);

                if (end.diff(start, 'months') >= 12) {
                    start = moment(this.account_start);
                }

                if (end.diff(moment(this.lifetime_end_date), 'months') <= 12 & end.diff(moment(this.lifetime_end_date), 'months') >= 0) {
                    end = moment(this.lifetime_end_date);
                }

                let months = end.diff(start, 'months');

                return months;
            },

            getNetBookValue() {
                let nbv = parseFloat(this.costs.value) - parseFloat(this.deprec.charges);

                return this.round(nbv);
            },
        }
    }
</script>