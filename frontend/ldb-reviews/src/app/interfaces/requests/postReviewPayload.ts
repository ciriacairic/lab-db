export interface PostReviewPayload {
  game_id: number;
  user_id: number;
  markdown_text: string;
  scores: {
    graphics: number;
    gameplay: number;
    sound: number;
    story: number;
    nostalgic: number;
  }
}