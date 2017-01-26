Vue.component('menu-grid', {
    template: '#menu-template',
    replace: true,
    props: {
        products: Array,
        sections: Array,
        categories: Array,
        init: Array,
        init_images: Array,
        persons: Number,
        weight_person: Boolean,
        tax: Number,
        template: String,
        category: Object,
        images: Array
    },
    created: function () {
        this.sections = this.init;
        this.images = this.init_images;
    },
    mounted: function() {
        var data = this;
        bus.$on('set-category', function (category) {
            data.category = category;
            this.category = category;
        });
    },
    computed: {
        sectionsJSON: function () {
            return JSON.stringify(this.sections);
        },
        imagesJSON: function () {
            return JSON.stringify(this.images);
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
            $.fancybox(photo);
        },
        changeAmount: function(product, value) {
            if (!this.isSetCategory(this.category)) {
                this.sections.push({
                    category: this.category,
                    rows: []
                })
            }

            category = this.category;
            self = this;
            this.sections = this.sections.map(function(section) {
                if (section.category.name == category.name) {
                    if (self.isSetProduct(section, product)) {
                        section.rows = section.rows.map(function (row) {
                            if (row.product.id == product.id) {
                                row.amount = value;
                            }
                            return row;
                        });
                    } else {
                        section.rows.push({product: product, amount: 1});
                    }
                }
                return section;
            });
        },
        getAmount: function(product) {
            var amount = 0;
            this.sections.filter(function (section) {
                section.rows.filter(function (row) {
                    if (row.product.id == product.id) {
                        amount = row.amount;
                    }
                });
            });
            return amount;
        },
        changeChecked: function(product, event) {
            console.log('this.images');
            console.log(this.images);

            if (event.target.checked) {
                this.addChecked(product);
            } else {
                this.deleteChecked(product);
            }
        },
        deleteChecked: function(product) {
            this.images = this.images.filter(function(image) {
                return image.id != product.id;
            });
        },
        addChecked: function(product) {
            if (this.images.filter(function(image) {
                    return image.id == product.id;
                }) > 0) {
                this.images = this.images.map(function(image) {
                    if (image.id == product.id) {
                        return product;
                    } else {
                        return image;
                    }
                })
            } else {
                this.images.push(product);
            }
        },
        getChecked: function(product) {
            return this.images.filter(function(image) {
                    return image.id == product.id;
                }).length > 0;
        },
        isSetCategory: function(category) {
            return this.sections.filter(function (item) {
                return category.name == item.category.name;
            }).length > 0;
        },
        isSetProduct: function(section, product) {
            return section.rows.filter(function (item) {
                    return item.product && (product.id == item.product.id);
                }).length > 0;
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
            this.select_category = category;
            bus.$emit('set-category', category);
        },
        clearCategory: function () {
            this.select_category = null;
            bus.$emit('set-category', null);
        },
        isVisible: function (category) {
            if (this.select_category == null) {
                return ((category.section1 != null)
                    && (category.section3 == null)
                    && (category.section4 == null));
            } else {
                if (
                    (category.section1 == this.select_category.section1) &&
                    (category.section2 == null) &&
                    (category.section3 == null) &&
                    (category.section4 == null)
                ) {
                    return true;
                }
                if (
                    (category.section1 == this.select_category.section1) &&
                    (category.section2 == this.select_category.section2) &&
                    (category.section3 == null) &&
                    (category.section4 == null)
                ) {
                    return true;
                }
                if (
                    (category.section1 == this.select_category.section1) &&
                    (category.section2 == this.select_category.section2) &&
                    (category.section3 == this.select_category.section3) &&
                    (category.section4 == null)
                ) {
                    return true;
                }
                if ((this.select_category.section1 == category.section1)
                    && (this.select_category.section2 != null)
                    && (this.select_category.section3 == null)
                    && (this.select_category.section4 == null)
                    && (category.section2 != null)
                    && (category.section3 == null)
                    && (category.section4 == null)
                ) {
                    return true;
                }
                if ((this.select_category.section1 == category.section1)
                    && (this.select_category.section2 == category.section2)
                    && (this.select_category.section3 != null)
                    && (this.select_category.section4 == null)
                    && (category.section3 != null)
                    && (category.section4 == null)
                ) {
                    return true;
                }
                if ((this.select_category.section1 == category.section1)
                    && (this.select_category.section2 == category.section2)
                    && (this.select_category.section3 == category.section3)
                    && (this.select_category.section4 != null)
                    && (category.section4 != null)
                ) {
                    return true;
                }
            }
            if (this.select_category == category) {
                return true;
            }
            if ((this.select_category != null) && (this.select_category.section2 == null) && (this.select_category.section3 == null) && (this.select_category.section4 == null)) {
                return ((category.section1 == this.select_category.section1)
                    && (category.section2 != null)
                    && (category.section3 == null)
                    && (category.section4 == null));
            }
            if ((this.select_category != null) && (this.select_category.section2 != null) && (this.select_category.section3 == null) && (this.select_category.section4 == null)) {
                return ((category.section1 == this.select_category.section1)
                && (category.section2 == this.select_category.section2)
                && (category.section3 != this.select_category.section3)
                && (category.section4 == null));
            }
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
                ]
            }
        ],
        images: [],
        persons: 1,
        weight_person: false,
        tax: 1,
        template: 'default',
        category: null
    }
});