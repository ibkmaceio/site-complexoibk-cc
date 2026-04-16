"use client";

import { useEffect, useRef, useState } from "react";

const VIDEO_ID = "WfIY1iTRjPg";

export default function HeroVideo() {
  const containerRef = useRef<HTMLDivElement>(null);
  const playerRef = useRef<YT.Player | null>(null);
  const [playing, setPlaying] = useState(false);

  useEffect(() => {
    let retryTimer: ReturnType<typeof setTimeout>;
    let mounted = true;

    function tryPlay(player: YT.Player, attempt = 0) {
      try {
        player.mute();
        player.playVideo();
      } catch {}

      if (attempt < 15) {
        retryTimer = setTimeout(() => {
          if (!mounted) return;
          try {
            if (player.getPlayerState() !== 1) {
              tryPlay(player, attempt + 1);
            }
          } catch {}
        }, 400);
      }
    }

    function createPlayer() {
      if (!containerRef.current || playerRef.current) return;

      playerRef.current = new window.YT.Player(containerRef.current, {
        videoId: VIDEO_ID,
        playerVars: {
          autoplay: 1,
          mute: 1,
          loop: 1,
          playlist: VIDEO_ID,
          controls: 0,
          showinfo: 0,
          rel: 0,
          modestbranding: 1,
          playsinline: 1,
          disablekb: 1,
          iv_load_policy: 3,
          origin: window.location.origin,
        },
        events: {
          onReady(e: YT.PlayerEvent) {
            tryPlay(e.target);
          },
          onStateChange(e: YT.OnStateChangeEvent) {
            if (e.data === 1 && mounted) {
              setPlaying(true);
            }
            if (e.data === 0) {
              e.target.playVideo();
            }
          },
        },
      });
    }

    if (window.YT?.Player) {
      createPlayer();
    } else {
      const prev = window.onYouTubeIframeAPIReady;
      window.onYouTubeIframeAPIReady = () => {
        prev?.();
        createPlayer();
      };
      if (!document.getElementById("yt-iframe-api")) {
        const tag = document.createElement("script");
        tag.id = "yt-iframe-api";
        tag.src = "https://www.youtube.com/iframe_api";
        document.head.appendChild(tag);
      }
    }

    return () => {
      mounted = false;
      clearTimeout(retryTimer);
    };
  }, []);

  return (
    <div
      className={`absolute inset-0 overflow-hidden bg-ibk-dark-deep transition-opacity duration-1000${
        playing ? " opacity-100 pointer-events-none" : " opacity-0"
      }`}
    >
      <div
        ref={containerRef}
        style={{
          position: "absolute",
          top: "50%",
          left: "50%",
          width: "100vw",
          height: "56.25vw",
          minHeight: "100%",
          minWidth: "177.78vh",
          transform: "translate(-50%, -50%)",
        }}
      />
    </div>
  );
}
