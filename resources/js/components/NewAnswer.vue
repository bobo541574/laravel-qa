<template>
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h3>Your Answer</h3>
          </div>
          <hr />
          <form @submit.prevent="create">
            <div class="form-group">
              <textarea v-model="body" name="body" class="form-control" rows="7" required></textarea>
            </div>
            <div class="form-group">
              <button
                :disabled="isInvalid"
                type="submit"
                class="btn btn-lg btn-outline-primary"
              >Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from "../event-bus";
export default {
  props: ["questionId"],
  data() {
    return {
      body: "",
    };
  },
  computed: {
    isInvalid() {
      return !this.signedIn || this.body.length < 10;
    },
  },
  methods: {
    create() {
      axios
        .post(`/questions/${this.questionId}/answers`, { body: this.body })
        .then(({ data }) => {
          //   console.log({ data });
          this.$toast.success(data.message, "Success", {
            timeout: 5000,
            position: "bottomLeft",
          });
          this.$emit("created", data.answer);
        });
    },
  },
};
</script>
