<template>
    <h1>Stats</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Link</th>
                <th>Total views</th>
                <th>Unique views</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows">
                <td><a :href="'/l/' + row.hash" target="_blank">{{ row.title || row.hash }}</a></td>
                <td>{{ row.total_views }}</td>                
                <td>{{ row.unique_views }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    data() {
        return {
            rows: []
        }
    },
    methods: {
        async fetchStats() {
            try {
                const response = await axios.get('/stats');
                this.rows = response.data;
            } catch (e) {
                alert("Error");
            }
        }
    },
        mounted() {
            console.log('mounted');
            this.fetchStats()
        }
    }
</script>

<style>

</style>