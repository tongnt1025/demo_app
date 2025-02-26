<template>
   
    <ul class="comment-list">
        <Alert v-if="showAlert" :type="alertType" :message="alertMessage" @close="showAlert = false" />
        <li v-for="comment in comments" :key="comment.id" class="comment">
            <div class="comment-body">
                <div class="d-flex gap-1 align-items-center">
                    <img class="avatar" :src="comment?.user?.avatar || placeholderImage">
                    <strong>{{ comment?.user?.name }}</strong>
                </div>
                <template v-if="editing === comment.id">
                    <textarea v-model="editedContent"></textarea>
                    <button class="save-btn" @click="saveEdit(comment.id)">Lưu</button>
                    <button class="cancel-btn" @click="cancelEdit">Hủy</button>
                </template>
                <template v-else>
                    <p style="margin-left:40px">{{ comment.content }}</p>
                    <div class="d-flex gap-2" style="margin-left:40px">
                        <button class="reply-btn" @click="toggleReply(comment.id)">Trả lời</button>
                        <button class="reply-btn" @click="toggleDelete(comment)">Xóa</button>
                        <button class="reply-btn" @click="toggleEdit(comment)">Sửa</button>
                    </div>
                </template>
            </div>

            <CommentForm v-if="replyingTo === comment.id" :parentId="getTopLevelParentId(comment)"
                @comment-added="onCommentAdded" />

            <CommentList v-if="comment.replies && comment.replies.length > 0" :comments="comment.replies"
                :depth="depth + 1" :top-level-comment="topLevelComment || comment.id"
                @refresh-all="$emit('refresh-all')" />
        </li>
    </ul>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import CommentForm from '@/components/client/CommentForm.vue';
import { deleteComment, updateComment } from '../../services/client/CommentService';
import placeholderImage from '../../assets/images/placeholder.png';
import { useAuthStore } from '../../stores/auth';
import Alert from '../admin/Alert.vue';
const authStore = useAuthStore();
const showAlert = ref(false);
const alertType = ref("success");
const alertMessage = ref("");
const emit = defineEmits(['refresh-all']);
const replyingTo = ref(null);
const editing = ref(null);
const editedContent = ref('');

const props = defineProps({
    comments: {
        type: Array,
        required: true
    },
    depth: {
        type: Number,
        default: 0
    },
    topLevelComment: {
        type: [Number, String],
        default: null
    }
});

const showAlertMessage = (type, message) => {
    showAlert.value = false;
    setTimeout(() => {
        alertType.value = type;
        alertMessage.value = message;
        showAlert.value = true;
    }, 100);
};

const getTopLevelParentId = (comment) => {
    if (props.depth === 0) {
        return comment.id;
    }

    if (props.topLevelComment) {
        return props.topLevelComment;
    }

    return comment.id;
};

const toggleReply = (commentId) => {
    replyingTo.value = replyingTo.value === commentId ? null : commentId;
};

const toggleDelete = async (comment) => {
    try {
        await deleteComment(comment.id);
        emit('refresh-all');
    } catch (error) {
       if(!authStore.user){showAlertMessage("danger", "Vui lòng đăng nhập!");}
        console.error("Lỗi khi xóa bình luận:", error);
    }
};

const toggleEdit = (comment) => {
    editing.value = comment.id;
    editedContent.value = comment.content;
};

const cancelEdit = () => {
    editing.value = null;
    editedContent.value = '';
};

const saveEdit = async (commentId) => {
    try {
        const formData = new FormData();
        formData.append('content', editedContent.value);
        formData.append('_method', 'PUT');

        await updateComment(commentId, formData);
        editing.value = null;


        emit('refresh-all');
    } catch (error) {
        if(!authStore.user){showAlertMessage("danger", "Vui lòng đăng nhập!");}
        console.error("Lỗi khi cập nhật bình luận:", error);
    }
};

const onCommentAdded = () => {
    replyingTo.value = null;
    emit('refresh-all');
};
</script>

<style scoped>
.comment-list {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.comment {
    padding: 12px 0;
    position: relative;
}

.comment-body {
    display: flex;
    flex-direction: column;
    background: #f0f2f5;
    padding: 12px 16px;
    border-radius: 12px;
    margin-bottom: 8px;
    transition: background-color 0.2s ease;
}

.comment-body:hover {
    background: #e4e6e9;
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.comment-list .comment-list {
    margin-left: 28px;
    padding-left: 20px;
    border-left: 2px solid #e4e6e9;
    position: relative;
}

.comment-list .comment-list::before {
    content: '';
    position: absolute;
    left: -2px;
    top: 0;
    height: 20px;
    width: 20px;
    border-bottom-left-radius: 12px;
    border-left: 2px solid #e4e6e9;
    border-bottom: 2px solid #e4e6e9;
}

.comment-list .comment-list .comment-body {
    background: #ffffff;
    border: 1px solid #e4e6e9;
}

.comment-list .comment-list .comment-body:hover {
    background: #f8f9fa;
}

.reply-btn,
.save-btn,
.cancel-btn {
    background: transparent;
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: background-color 0.2s ease;
}

.reply-btn:hover {
    background: #e4e6e9;
    color: #1a73e8;
}

.save-btn {
    color: #34a853;
}

.save-btn:hover {
    background: #e8f5e9;
}

.cancel-btn {
    color: #ea4335;
}

.cancel-btn:hover {
    background: #fce8e6;
}

textarea {
    width: 100%;
    height: 80px;
    padding: 8px 12px;
    border: 1px solid #e4e6e9;
    border-radius: 8px;
    margin: 8px 0;
    font-family: inherit;
    resize: vertical;
}

textarea:focus {
    outline: none;
    border-color: #1a73e8;
    box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.1);
}

.more-replies {
    margin-top: 8px;
    margin-left: 28px;
}

.more-replies button {
    background: transparent;
    border: none;
    color: #1a73e8;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.more-replies button:hover {
    background: #f1f3f4;
    text-decoration: underline;
}
</style>