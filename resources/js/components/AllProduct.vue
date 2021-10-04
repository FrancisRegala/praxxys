<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/all" class="btn btn-success m-2">Products List</router-link>
                    <router-link to="/create" class="btn btn-primary m-2">Create Product</router-link>
                    <a href="/dashboard" class="btn btn-primary m-2">Dashboard </a>
                    <!-- <router-link to="/test" class="btn btn-info m-2">Dashboard</router-link> -->
                </div>
            </div>
        </nav>
        <h2 class="text-center">Products List</h2>

        <!-- <data-table
            :columns="columns"
            url="http://localhost:8000/api/products">
        </data-table> -->
        <input type="text"
            class="form-control"
            placeholder="Search by name and description"
            v-model="searchTerm" v-on:input="getSearch()" />
        <select name="selectedCategory" @change="getCategory($event)" class="form-control" v-model="selectedCategory">
            <option value="-" disabled>Filtered by Category</option>
            <option value="A">A</option>
            <option value="B">B</option>
        </select>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>DateTime</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in productsFiltered" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.category }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.datetime }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: product.id }}" class="btn btn-success">Edit</router-link>
                        <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item">
					<button type="button" class="page-link" @click="page--"> Previous </button>
				</li>
				<li class="page-item">
					<button type="button" class="page-link" v-for="pageNumber in 1" :key="pageNumber"> {{pageNumber}} </button>
				</li>
				<li class="page-item">
					<button type="button" @click="page++" class="page-link"> Next </button>
				</li>
			</ul>
		</nav>	
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                page: 1,
                pages:10,
                searchTerm: '',
                selectedCategory: '-',
                products: [],
                productsFiltered: [],
                columns: [
                    {
                        label: 'ID',
                        name: 'id',
                        orderable: true,
                    },
                    {
                        label: 'Name',
                        name: 'name',
                        orderable: true,
                    },
                    {
                        label: 'Category',
                        name: 'category',
                        orderable: true,
                    },
                    {
                        label: 'Description',
                        name: 'description',
                        orderable: true,
                    },
                    {
                        label: 'Date and Time',
                        name: 'datetime',
                        orderable: true,
                    },
                    {
                        label: 'Action',
                        name: 'action'
                    }
                ]
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/products')
                .then(response => {
                    this.products = response.data;
                    this.productsFiltered = response.data;
                });
        },
        methods: {
            deleteProduct(id) { 
                this.axios
                    .delete(`http://localhost:8000/api/products/${id}`)
                    .then(response => {
                        let i = this.products.map(data => data.id).indexOf(id);
                        this.products.splice(i, 1)
                    });
            },
            getSearch() {
                const filtered = this.products.filter((data) => {
                    return data.name.includes(this.searchTerm) || data.description.includes(this.searchTerm);
                });
                this.productsFiltered = filtered;
            },
            getCategory(event) {
                console.log(event.target.value)
                const filtered = this.products.filter((data) => {
                    return data.category.includes(event.target.value);
                });
                this.productsFiltered = filtered;
            }
        }
    }
</script>