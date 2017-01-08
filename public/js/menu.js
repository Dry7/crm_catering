Vue.component('menu-grid', {
    template: '#menu-template',
    replace: true,
    props: {
        products: Array,
        sections: Array,
        categories: Array,
        init: Array,
        persons: Number,
        weight_person: Boolean,
        tax: Number,
        template: String,
        category: Object
    },
    created: function () {
        this.sections = this.init;
    },
    mounted: function() {
        var data = this;
        bus.$on('set-category', function (category) {
            console.log('set-category');
            console.log(category);
            data.category = category;
            this.category = category;
        });
    },
    computed: {
        sectionsJSON: function () {
            return JSON.stringify(this.sections);
        }
    },
    filters: {
        price: function (price) {
            if ((typeof price != 'number') || isNaN(price)) {
                return '';
            }
            return price + ' р.';
        },
        amount: function (amount) {
            if ((typeof amount != 'number') || isNaN(amount)) {
                return '';
            }
            return amount + ' шт.';
        },
        weight: function (weight) {
            if ((typeof weight != 'number') || isNaN(weight)) {
                return '';
            }
            return weight + ' гр.';
        },
        total: function (price) {
            return price > 0 ? price : '';
        }
    },
    methods: {
        addRow: function(section) {
            section.rows.push({product: "", amount: null});
        },
        deleteRow: function(section, index) {
            section.rows.splice(index, 1);
            if (section.rows.length == 0) {
                this.deleteSection(section);
            }
        },
        addSection: function() {
            this.sections.push({category: null, rows: [{product: "", amount: null}]});
        },
        deleteSection: function (section) {
            this.sections = this.sections.filter(function (item) {
                return item != section;
            })
        },
        filteredData: function (category) {
            var filterKey = category;
            var sortKey = 'name';
            var order = 1;
            var data = this.products;

                data = data.filter(function (item) {
                    if (filterKey) {
                        if (filterKey.section1 && (item.section1 != filterKey.section1)) {
                            return false;
                        }
                        if (filterKey.section2 && (item.section2 != filterKey.section2)) {
                            return false;
                        }
                        if (filterKey.section3 && (item.section3 != filterKey.section3)) {
                            return false;
                        }
                        if (filterKey.section4 && (item.section4 != filterKey.section4)) {
                            return false;
                        }
                        return true;
                    } else {
                        return false;
                    }
                    return filterKey ? Number(item.category) == Number(filterKey) : true;
                });

            if (sortKey) {
                data = data.slice().sort(function (a, b) {
                    a = a[sortKey]
                    b = b[sortKey]
                    return (a === b ? 0 : a > b ? 1 : -1) * order
                })
            }

            console.log('asd');
            console.log(filterKey);
            console.log(data);

            return data;
        },
        totalAmount: function (section) {
            return 0;
            return section.rows.reduce(function (total, row) {
                var item = parseInt(row.amount);
                return total + (item > 0 ? item : 0);
            }, 0);
        },
        totalPrice: function (section) {
            return 0;
            return section.rows.reduce(function (total, row) {
                var item = row.product != null ? parseInt(row.product.price)*parseInt(row.amount) : 0;
                return total + (item > 0 ? item : 0);
            }, 0);
        },
        weightPerson: function (weight, amount) {
            return Math.ceil(Number(weight) * Number(amount) / this.persons);
        },
        changeProduct: function (row, event) {
            row.product = this.products.filter(function (product) {
                return Number(product.id) == Number(event.target.value);
            })[0];
        },
        categoryList: function (category) {
            var level = 0;
            if (category.section2 !== null) { level++; }
            if (category.section3 !== null) { level++; }
            if (category.section4 !== null) { level++; }

            var r = '';

            while (level > 0) {
                r += '--';
                level--;
            }

            return r;
        },
        openPhoto: function (photo) {
            console.log(photo);
            $.fancybox(photo);
        }
    }
});

Vue.component('menu-categories', {
    template: '#menu-categories-template',
    replace: true,
    props: {
        categories: Array,
        select_category: Object
    },
    methods: {
        categoryList: function (category) {
            var level = 0;
            if (category.section2 !== null) { level++; }
            if (category.section3 !== null) { level++; }
            if (category.section4 !== null) { level++; }

            var r = '';

            while (level > 0) {
                r += '--';
                level--;
            }

            return r;
        },
        setCategory: function (category) {
            console.log('setCategory');
            this.select_category = category;
            bus.$emit('set-category', category);
        }
    }
});

// bootstrap the demo
var bus = new Vue();

var categories = new Vue({
    el: '#categories',
    data: {
        category: null
    }
});

var menu = new Vue({
    el: '#menu',
    data: {
        products: [],
        sections: [
            {
                category: "",
                rows: [
                    {product: "", amount: null}
                ]
            }
        ],
        persons: 1,
        weight_person: false,
        tax: 1,
        template: 'default',
        category: null
    }
});