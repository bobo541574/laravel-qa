<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <form class="card-body" v-if="editing" @submit.prevent="update">
          <div class="card-title">
            <input type="text" class="form-control form-control-lg" v-model="title" />
          </div>

          <hr />

          <div class="media">
            <div class="media-body">
              <div class="form-group">
                <textarea rows="10" v-model="body" class="form-control"></textarea>
              </div>
              <button class="btn btn-outline-info btn-sm" :disabled="isInvalid">Update</button>
              <button
                type="button"
                @click.prevent="cancle"
                class="btn btn-outline-danger btn-sm"
              >Cancle</button>
            </div>
          </div>
        </form>
        <div class="card-body" v-else>
          <div class="card-title">
            <div class="d-flex align-item-center">
              <h1>{{ title }}</h1>
              <div class="ml-auto">
                <a href="/questions" class="btn btn-outline-secondary">Back to all Question</a>
              </div>
            </div>
          </div>

          <hr />

          <div class="media">
            <vote name="question" :model="question"></vote>
            <div class="media-body">
              <div v-html="bodyHtml"></div>
              <div class="row">
                <div class="col-md-4">
                  <a
                    v-if="authorize('modify', question)"
                    @click.prevent="edit"
                    class="btn btn-sm btn-outline-info"
                  >Edit</a>
                  <button
                    v-if="authorize('deleteQuestion', question)"
                    @click="destroy"
                    class="btn btn-sm btn-outline-danger"
                  >Delete</button>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <user-info :model="question" label="Asked"></user-info>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import UserInfo from "./UserInfo";
import Vote from "./Vote";

export default {
  components: {
    UserInfo,
    Vote,
  },
  props: ["question"],
  data() {
    return {
      title: this.question.title,
      body: this.question.body,
      bodyHtml: this.question.body_html,
      editing: false,
      id: this.question.id,
      beforeEditCache: {},
    };
  },
  computed: {
    isInvalid() {
      return this.body.length < 10 || this.title.length < 10;
    },

    endpoint() {
      return `/questions/${this.id}`;
    },
  },

  methods: {
    edit() {
      this.beforeEditCache = {
        body: this.body,
        title: this.title,
      };

      this.editing = true;
    },

    cancle() {
      this.body = this.beforeEditCache.body;
      this.title = this.beforeEditCache.title;
      this.editing = false;
    },

    update() {
      axios
        .put(this.endpoint, {
          body: this.body,
          title: this.title,
        })
        .catch(({ response }) => {
          this.$toast.error(response.data.message, "Error", {
            timeout: 5000,
            position: "bottomLeft",
          });
        })
        .then(({ data }) => {
          this.$toast.success(data.message, "Success", {
            timeout: 5000,
            position: "bottomLeft",
          });
          this.bodyHtml = data.body_html;
          this.title = data.title;
          this.editing = false;
        });
    },

    destroy() {
      this.$toast.question("Are you sure about that?", "Confirm", {
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: "once",
        id: "question",
        zindex: 999,
        title: "Hey",
        position: "center",
        buttons: [
          [
            "<button><b>YES</b></button>",
            (instance, toast) => {
              axios.delete(this.endpoint).then((res) => {
                this.$toast.success(res.data.message, "Success", {
                  timeout: 2000,
                  position: "buttonLeft",
                });
              });
              setTimeout(() => {
                window.location.href = "/questions";
              }, 3000);
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
            true,
          ],
          [
            "<button>NO</button>",
            function (instance, toast) {
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
          ],
        ],
      });
    },
  },
};
</script>
