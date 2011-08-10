<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<script src="http://widgets.twimg.com/j/2/widget.js" type="text/javascript"></script>
<script type="text/javascript">
new TWTR.Widget({
  version: 2,
  type: 'search',
  search: 'from:birthofn OR @birthofn OR #birthofn',
  interval: 12000,
  title: 'Twitter de #birthofn',
  subject: '@birthofn',
  width: 250,
  height: 300,
  theme: {
    shell: {
      background: '#8ec1da',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#444444',
      links: '#1985b5'
    }
  },
  features: {
    scrollbar: true,
    loop: false,
    live: false,
    hashtags: true,
    timestamp: true,
    avatars: true,
    toptweets: false,
    behavior: 'all'
  }
}).render().start();
</script>