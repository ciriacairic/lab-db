export interface PostCommentPayload {
  parent_id: number;
  parent_type: 'review' | 'comment';
  user_id: number;
  text: string;
}