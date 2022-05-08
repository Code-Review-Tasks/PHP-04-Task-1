<template>
    <h2>Edit link</h2>

    <div id="response" class="fw-bold">{{ response }}</div>

    <div class="mb-3">
        <label for="cf-url">Long URL:</label>
        <input
            v-model="long_url"
            class="form-control"
            type="url"
            name="cf-url"
            id="cf-url"
            placeholder="https://support.google.com/websearch"
            required
        />
    </div>
    <div class="mb-3">
        <label for="cf-title">Title:</label>
        <input
            v-model="title"
            class="form-control"
            type="text"
            name="cf-title"
            id="cf-title"
            placeholder="My Link"
            required
        />
    </div>
    <div class="mb-3">
        <label for="cf-url">Tags space separated:</label>
        <input
            v-model="tags"
            class="form-control"
            type="text"
            name="cf-tags"
            id="cf-tags"
            placeholder="homepage mylink search_engines"
        />
    </div>

    <button type="button" class="btn btn-primary" @click="patchLink">Update</button>
</template>

<script>
export default {
    data() {
        return {
            long_url: '',
            title: '',
            tags: '',
            response: ''
        }
    },
    methods: {
        inputToTags(event, index) {
            const v = event.target.value.trim();
            this.tags = v == "" ? [] : event.target.value.trim().replace(/\s\s+/g, ' ').split(" ").map(item => item.trim());
        },
        async fetchLink() {
            const response = await axios.get('/links/' + this.$route.params.id);
            this.long_url = response.data.long_url;
            this.title = response.data.title;
            this.tags = response.data.tags.map(t => t.name).join(' ');
        },
        patchLink() {
            let tags = this.tags == "" ? [] : this.tags.trim().replace(/\s\s+/g, ' ').split(" ").map(item => item.trim());
            axios.patch('/links/' + this.$route.params.id, {
                long_url: this.long_url,
                title: this.title,
                tags: tags
            })
            .then(response => this.response = response.data)
            .catch(error => this.response = error.response.status + ': ' + error.response.data.message)
            .finally();
        }
    },
    mounted() {
        this.fetchLink();
    }
};
</script>

<style></style>
