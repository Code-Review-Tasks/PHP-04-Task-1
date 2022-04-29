<template>
    <h2>Add new link</h2>

    <div id="response" class="fw-bold">{{ response }}</div>
    
    <div v-for="(link, index) in links" :class="{ 'bg-success bg-opacity-10': index % 2 == 1 }" class="p-2 rounded">
        <div class="mb-3">
            <label for="cf-url">Long URL:</label>
            <input
                v-model="link.long_url"
                class="form-control"
                type="url"
                name="cf-url"
                id="cf-url"
                placeholder="https://support.google.com/websearch"
                required
            >
        </div>
        <div class="mb-3">
            <label for="cf-title">Title:</label>
            <input
                v-model="link.title"
                class="form-control"
                type="text"
                name="cf-title"
                id="cf-title"
                placeholder="My Link"
                required
            >
        </div>
        <div class="mb-3">
            <label for="cf-url">Tags space separated:</label>
            <input                
                @input="inputToTags($event, index)"
                class="form-control"
                type="text"
                name="cf-tags"
                id="cf-tags"
                placeholder="homepage mylink search_engines"
                :value="link.tags.join(' ')"
            >
        </div>
    </div>

    <hr>

    <button type="button" class="btn btn-primary me-1" @click="addLink">+</button>
    <button type="button" class="btn btn-primary me-1" @click="removeLink" v-if="links.length > 1">-</button>
    <button type="button" class="btn btn-primary" @click="submitLinks">Submit</button>
    
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            links: [
                {long_url: '', title: '', tags: []}
            ],
            response: ''
        }
    },
    methods: {
        submitLinks() {            

            let json = this.links.length == 1 ? this.links[0] : this.links;            

            axios.post('/links', json)
            .then(response => {
                this.response = response.data;
                this.links = [{long_url: '', title: '', tags: []}];
            })
            .catch(error => this.response = error.response.status + ': ' + error.response.data.message)
            .finally();

        },
        addLink() {
            this.links.push({long_url: '', title: '', tags: []});
        },
        removeLink() {
            this.links.splice(-1);
        },
        inputToTags(event, index) {
            const v = event.target.value.trim();
            this.links[index].tags = v == "" ? [] : event.target.value.trim().replace(/\s\s+/g, ' ').split(" ").map(item => item.trim());
        }
    }
}
</script>

<style>

</style>