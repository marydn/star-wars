<template>
    <div>
        <form class="form-inline">
            <div class="form-group">
                <label for="endpoint">Endpoint:</label>
                <input id="endpoint" name="endpoint" type="url" placeholder="https://" class="form-control" v-model.trim.lazy="endpoint" />
            </div>

            <button type="submit" class="btn btn-primary" @click.prevent="submit">Consultar</button>
        </form>

        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="status === 'loading'">
                <td colspan="2">Cargando...</td>
            </tr>
            <tr v-if="status === 'fail'">
                <td colspan="2" class="text-center">Load has failed. You can <a href="#" @click.prevent="submit">retry</a> the fetch.</td>
            </tr>
            <tr v-for="(item, index) in items" :key="index" v-show="items.length">
                <td>{{ index }}</td>
                <td><a :href="item.url">{{ item.name }}</a></td>
            </tr>
            </tbody>
        </table>

        <nav aria-label="Page navigation example" v-show="items.length">
            <ul class="pagination">
                <li class="page-item" :class="{disabled: !previousPage}">
                    <a href="#" class="page-link" @click.prevent="goToPreviuos">Previuos</a>
                </li>
                <li class="page-item" v-for="(page, index) in pages" :key="index" :class="{active: page === currentPage}">
                    <a href="#" class="page-link" @click.prevent="goToPage(page)">
                        {{ page }}
                    </a>
                </li>
                <li class="page-item" :class="{disabled: !nextPage}">
                    <a href="#" class="page-link" @click.prevent="goToNext">Next</a>
                </li>
            </ul>
        </nav>

        <ul>
            <li>Current page: {{ currentPage }}</li>
            <li>Next page: <a href="#" @click.prevent="goToPreviuos">{{ previousPage }}</a></li>
            <li>Previous page: <a href="#" @click.prevent="goToNext">{{ nextPage }}</a></li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'ApiFetcher',
    data() {
        return {
            status: '',
            endpoint: 'https://swapi.co/api/people/?format=json',

            items: [],
            currentPage: 1,
            total: null,
            itemsPerPage: 10,
            nextPage: null,
            previousPage: null
        }
    },
    computed: {
        pages() {
            return Math.ceil(this.total/this.itemsPerPage)
        },
    },
    methods: {
        goToPage(page) {
            let url = new window.URL(this.endpoint)
            let params = url.searchParams

            params.set('page', page)

            this.endpoint = url.toString()
            this.currentPage = page

            return this.submit()
        },
        goToPreviuos() {
            if (!this.previousPage) return

            this.endpoint = this.previousPage
            this.currentPage--
            this.submit()
        },
        goToNext() {
            if (!this.nextPage) return

            this.endpoint = this.nextPage
            this.currentPage++
            this.submit()
        },
        submit() {
            const endpoint = encodeURIComponent(this.endpoint)
            this.status = 'loading'
            this.items = []
            axios.get('/starwars.json?endpoint='+endpoint)
                .then(({data}) => {
                    if (data.hasOwnProperty('results')) {
                        this.items = data.results
                        this.total = data.count
                        this.previousPage = data.previous
                        this.nextPage = data.next

                        this.status = ''
                    } else {
                        this.status = 'fail'
                    }
                })
                .catch(error => this.status = 'fail')
        }
    }
}
</script>