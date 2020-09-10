<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        @include('shared._vote', [
        'model' => $answer
        ])
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
                {{-- {{ $answer->body_html }} --}}
                <div class="row">
                    <div class="col-4">
                        @can('update', $answer)
                        {{-- <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}"
                            class="btn btn-sm btn-outline-info">Edit</a> --}}
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
                        {{-- @include('shared._author', [
                        'model' => $answer,
                        'label' => 'answered'
                        ]) --}}
                        <user-info :model="{{ $answer }}" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @if (!$loop->last)
    <hr>
    @endif --}}
</answer>

