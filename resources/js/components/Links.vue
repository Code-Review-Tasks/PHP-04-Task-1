<template>
    <h1>Links</h1>

    <nav>
        <ul class="pagination">
            <li
                class="page-item"
                v-for="link in paginationLinks"
                :class="{ disabled: !link.url, active: link.active }"
            >
                <a
                    href="#"
                    class="page-link"
                    v-html="link.label"
                    @click="changePage(link.url)"
                ></a>
            </li>
        </ul>
    </nav>

    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item" v-for="link in links" :key="link.id">
                <a :href="'/#/stats/' + link.hash" class="badge bg-info me-1 text-decoration-none">S</a>
                <a :href="'/#/edit/' + link.hash" class="badge bg-success me-1 text-decoration-none">E</a>
                <a href="#" @click.prevent="deleteLink(link.hash)" class="badge bg-danger me-1 text-decoration-none">D</a>
                <a :href="'/l/' + link.hash" target="_blank">{{
                    link.title || link.hash
                }}</a>
                {{ link.long_url }}
                <a href="#" class="badge bg-secondary me-1 text-decoration-none" v-for="tag in link.tags" @click="tagFilter = tag.name; currentPageUrl = '/links'; fetchLinks()">
                    {{ tag.name }}
                </a>
            </li>
        </ul>
    </div>

    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="filterByTitle" class="col-form-label">Filter by Title</label>
        </div>
        <div class="col-auto">
            <input v-model="titleFilter" v-on:keyup.enter="currentPageUrl = '/links'; fetchLinks()" type="text" id="filterByTitle" class="form-control"/>
        </div>

        <div class="col-auto">
            <label for="filterByTag" class="col-form-label">Filter by Tag</label>
        </div>
        <div class="col-auto">
            <input v-model="tagFilter" v-on:keyup.enter="currentPageUrl = '/links'; fetchLinks()" type="text" id="filterByTag" class="form-control"/>
        </div>

        <div class="col-auto">
            <button class="btn btn-primary" @click="currentPageUrl = '/links'; fetchLinks()">Refresh</button>
        </div>

        <div class="col-auto">
            <button class="btn btn-primary" @click="currentPageUrl = '/links'; titleFilter = ''; tagFilter = ''; fetchLinks()">Clear</button>
        </div>
        
    </div>

</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            links: [],
            paginationLinks: [],
            currentPageUrl: "/links",
            titleFilter: "",
            tagFilter: ""
        };
    },
    methods: {
        async fetchLinks() {
            try {
                let params = {};

                if (this.titleFilter) {
                    params.title = this.titleFilter;
                }

                if (this.tagFilter) {
                    params.tag = this.tagFilter;
                }

                const response = await axios.get(this.currentPageUrl, {params: params});
                this.links = response.data.data;
                this.paginationLinks = response.data.meta.links;
            } catch (e) {
                alert("Error");
            }
        },
        changePage(url) {
            this.currentPageUrl = url;
            this.fetchLinks();
        },
        deleteLink(hash) {
            axios.delete('/links/' + hash).then(response => this.fetchLinks());
        }
    },
    mounted() {
        this.fetchLinks();
    },
};
</script>

<style scoped></style>
