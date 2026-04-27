"use client";

import { useEffect, useState } from "react";

type DebugState = {
  isLive: boolean;
  liveVideoId: string | null;
  lastCompletedId: string | null;
  postLiveUntil: number;
  postLiveRemaining: number; // segundos restantes na janela
  lastRetry: number;
  nextRetryIn: number; // segundos até próximo retry
  wasLive: boolean;
};

function readState(): DebugState {
  const now = Date.now();
  const postLiveUntil = Number(localStorage.getItem("ibk_post_live_until_v1") ?? "0");
  const lastRetry = Number(localStorage.getItem("ibk_post_live_retry_v1") ?? "0");
  const INTERVAL = 3 * 60 * 1000;

  let liveCheck = null;
  try { liveCheck = JSON.parse(localStorage.getItem("ibk_live_check_v1") ?? "null"); } catch {}
  let completed = null;
  try { completed = JSON.parse(localStorage.getItem("ibk_last_completed_v1") ?? "null"); } catch {}

  return {
    isLive: liveCheck?.isLive ?? false,
    liveVideoId: localStorage.getItem("ibk_live_video_id_v1"),
    lastCompletedId: completed?.videoId ?? null,
    postLiveUntil,
    postLiveRemaining: Math.max(0, Math.floor((postLiveUntil - now) / 1000)),
    lastRetry,
    nextRetryIn: lastRetry ? Math.max(0, Math.floor((lastRetry + INTERVAL - now) / 1000)) : 0,
    wasLive: localStorage.getItem("ibk_was_live_v1") === "1",
  };
}

function fmt(s: number) {
  const m = Math.floor(s / 60);
  const sec = s % 60;
  return `${m}:${String(sec).padStart(2, "0")}`;
}

export default function LiveDebugOverlay() {
  const [state, setState] = useState<DebugState | null>(null);

  useEffect(() => {
    // Só renderiza se ?debug=live estiver na URL
    if (!window.location.search.includes("debug=live")) return;
    setState(readState());
    const id = setInterval(() => setState(readState()), 1000);
    return () => clearInterval(id);
  }, []);

  if (!state) return null;

  const inPostLive = state.postLiveRemaining > 0;

  const row = (label: string, value: React.ReactNode) => (
    <div className="flex justify-between gap-4">
      <span className="text-white/50">{label}</span>
      <span className="text-white font-mono">{value}</span>
    </div>
  );

  return (
    <div className="fixed bottom-4 right-4 z-[9999] w-72 bg-black/90 border border-white/10 rounded-lg p-4 text-xs font-body shadow-2xl">
      <div className="flex items-center justify-between mb-3">
        <span className="text-white/40 uppercase tracking-widest text-[10px]">Live Debug</span>
        <span className={`px-2 py-0.5 rounded text-[10px] font-bold ${state.isLive ? "bg-[#E84C1E] text-white" : "bg-white/10 text-white/50"}`}>
          {state.isLive ? "● AO VIVO" : "○ offline"}
        </span>
      </div>

      <div className="space-y-1.5">
        {row("wasLive flag", state.wasLive ? "✓ sim" : "✗ não")}
        {row("liveVideoId", state.liveVideoId
          ? <a href={`https://youtu.be/${state.liveVideoId}`} target="_blank" rel="noreferrer" className="text-[#E84C1E] underline">{state.liveVideoId}</a>
          : "—")}
        {row("lastCompleted", state.lastCompletedId
          ? <a href={`https://youtu.be/${state.lastCompletedId}`} target="_blank" rel="noreferrer" className="text-[#E84C1E] underline">{state.lastCompletedId}</a>
          : "—")}
      </div>

      <div className="my-3 border-t border-white/10" />

      <div className="space-y-1.5">
        <div className="flex items-center gap-2 mb-1">
          <span className={`w-2 h-2 rounded-full ${inPostLive ? "bg-yellow-400 animate-pulse" : "bg-white/20"}`} />
          <span className={inPostLive ? "text-yellow-300" : "text-white/40"}>
            {inPostLive ? "janela pós-live ativa" : "fora da janela pós-live"}
          </span>
        </div>
        {inPostLive && (
          <>
            {row("janela expira em", fmt(state.postLiveRemaining))}
            {row("próx. retry em", state.nextRetryIn > 0 ? fmt(state.nextRetryIn) : "agora")}
          </>
        )}
      </div>

      <div className="my-3 border-t border-white/10" />

      <div className="flex gap-2">
        <button
          onClick={() => {
            localStorage.setItem("ibk_was_live_v1", "1");
            localStorage.setItem("ibk_live_video_id_v1", state.lastCompletedId ?? "");
            localStorage.removeItem("ibk_live_check_v1");
            setState(readState());
          }}
          className="flex-1 px-2 py-1.5 bg-white/8 hover:bg-white/15 rounded text-white/60 hover:text-white transition-all text-[10px]"
        >
          Simular live
        </button>
        <button
          onClick={() => {
            // Simula fim de live — abre janela pós-live
            localStorage.setItem("ibk_was_live_v1", "0");
            localStorage.removeItem("ibk_post_live_until_v1");
            localStorage.removeItem("ibk_post_live_retry_v1");
            localStorage.removeItem("ibk_last_completed_v1");
            const until = String(Date.now() + 10 * 60 * 1000);
            localStorage.setItem("ibk_post_live_until_v1", until);
            setState(readState());
          }}
          className="flex-1 px-2 py-1.5 bg-[#E84C1E]/20 hover:bg-[#E84C1E]/40 rounded text-[#E84C1E] hover:text-white transition-all text-[10px]"
        >
          Simular fim
        </button>
        <button
          onClick={() => {
            ["ibk_live_check_v1","ibk_last_completed_v1","ibk_post_live_until_v1",
             "ibk_post_live_retry_v1","ibk_live_video_id_v1","ibk_was_live_v1"].forEach(k =>
              localStorage.removeItem(k));
            setState(readState());
          }}
          className="px-2 py-1.5 bg-white/8 hover:bg-white/15 rounded text-white/40 hover:text-white transition-all text-[10px]"
        >
          Reset
        </button>
      </div>
    </div>
  );
}
