<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        <vote name="answer" :model="{{ $answer }}"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea rows="10" v-model="body" class="form-control"></textarea>
                </div>
                <button class="btn btn-outline-info btn-sm" :disabled="isInvalid">Update</button>
                <button type="button" @click.prevent="cancle" class="btn btn-outline-danger btn-sm">Cancle</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        @can('update', $answer)
                            <a @click.prevent="edit"
                                class="btn btn-sm btn-outline-info">Edit</a>
                        @endcan
        
                        @can('delete', $answer)
                            <button @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                        @endcan
                    </div>
                    <div class="col-4">
                    </div>
                    <div class="col-4">
                        <user-info :model="{{ $answer }}" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>

