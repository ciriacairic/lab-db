export interface PostReportPayload {
  reported_type: string;
  target_id: string;
  user_id: number;
  reason: string;
  status: string;
}