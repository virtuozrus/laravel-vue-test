<template>
  <div id="app">
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <form>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Your comment:</label>
          <textarea class="form-control" rows="3" v-model="comment_text"></textarea>
          <button type="button" class="btn btn-light" @click="send_comment">Send comment</button>
        </div>
      </form>

      <h6 class="border-bottom border-gray pb-2 mb-0">Recent comments</h6>

      <div class="media text-muted pt-3" v-for="comment in comments">
        <img class="mr-2 rounded" src="https://dummyimage.com/32x32/6f42c1/6f42c1.png" style="width: 32px; height: 32px;">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">@{{ comment.user }}</strong> {{ comment.text }}
        </p>
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Actions
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Edit</a>
            <a class="dropdown-item" href="#">Delete</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script src="./App.js"></script>
