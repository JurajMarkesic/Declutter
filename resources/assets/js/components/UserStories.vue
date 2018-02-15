<template>
    <div>
        <user-story v-for="story in stories" :story="story" :user="user" :isLogged="isLoggedIn" :key="story.id"></user-story>
        <ul class="pagination justify-content-center">
            <li :class="{'page-item': true, 'disabled': !pagination.prev_page_url}">
                <a class="page-link" href="#" aria-label="Previous" @click="fetch(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">
                    <span aria-hidden="true">Previous</span>
                </a>
            </li>
            <li class="page-item disabled">
                <span class="page-link" style="color: black">Page {{pagination.current_page}} of {{pagination.last_page}}</span>
            </li>
            <li :class="{'page-item': true, 'disabled': !pagination.next_page_url}">
                <a class="page-link" href="#" aria-label="Next" @click="fetch(pagination.next_page_url)" :disabled="!pagination.next_page_url">
                    <span aria-hidden="true">Next</span>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: [
            'isLoggedIn', 'user'
        ],
        data() {
            return {
                stories: [],
                pagination: {}
            }
        },
        methods: {
          fetch(page_url) {
              if(typeof(page_url) === 'undefined') {
                  page_url = '/stories/user/' + this.user.id;
              }
              axios.get(page_url)
                  .then(response => {
                      this.stories = response.data.stories.data;
                      this.makePagination(response.data.stories)
                  })
          },
            makePagination(data) {
                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url
                };
            }
        },
        created() {
            this.fetch();
        }

    }
</script>

<style>

</style>