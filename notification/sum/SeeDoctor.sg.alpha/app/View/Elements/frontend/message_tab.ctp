<ul>
<li class="<?php if($active=='inbox'){ echo "inbox_active" ; } else{ echo "inbox" ;}?>"><a href="<?php echo BASE_URL;?>messages/MessageInbox">Inbox</a></li>
<!--<li class="compose"><a href="<?php echo BASE_URL;?>messages/conversation/9/Clinicmanager">Compose</a></li>-->
<li class="<?php if($active=='compose'){ echo "compose_active" ; } else{ echo "compose" ;}?>" ><a href="<?php echo BASE_URL;?>messages/conversation">Compose</a></li>
<li class="<?php if($active=='outbox'){ echo "outbox_active" ; } else{ echo "outbox" ;}?>"><a href="<?php echo BASE_URL;?>messages/MessageOutbox" >Outbox</a></li>
<li class="<?php if($active=='trash'){ echo "draft_active" ; } else{ echo "draft" ;}?>"><a href="<?php echo BASE_URL;?>messages/MessageTrash">Trash</a></li>
</ul>

