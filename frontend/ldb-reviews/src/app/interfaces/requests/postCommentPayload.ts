export interface PostCommentPayload {
  parent_id: string;
  parent_type: 'review' | 'comment';
  user_id: number;
  text: string;
}