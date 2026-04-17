"use client";

import { useEffect, useRef } from "react";

export default function HeroVideo() {
  const videoRef = useRef<HTMLVideoElement>(null);

  useEffect(() => {
    const video = videoRef.current;
    if (!video) return;

    // iOS Safari ignora media attribute em <source> de <video> — detectar via JS
    const isMobile = window.matchMedia("(max-width: 767px)").matches;
    video.src = isMobile
      ? "/assets/video/hero-mobile.mp4"
      : "/assets/video/hero-desktop.mp4";

    // muted via JS é necessário para iOS Safari respeitar autoplay
    video.muted = true;

    const tryPlay = () => {
      video.play().catch(() => {});
    };

    // Tenta imediatamente — browser faz fila até ter dados suficientes
    tryPlay();

    // Backup: se o play imediato falhou por readyState insuficiente
    video.addEventListener("canplay", tryPlay, { once: true });

    const onVisibility = () => {
      if (document.visibilityState === "visible") tryPlay();
    };
    document.addEventListener("visibilitychange", onVisibility);

    return () => {
      video.removeEventListener("canplay", tryPlay);
      document.removeEventListener("visibilitychange", onVisibility);
    };
  }, []);

  return (
    <div className="absolute inset-0 overflow-hidden pointer-events-none bg-ibk-dark-deep">
      <video
        ref={videoRef}
        autoPlay
        muted
        loop
        playsInline
        preload="auto"
        disablePictureInPicture
        disableRemotePlayback
        aria-hidden="true"
        tabIndex={-1}
        className="hero-video"
        style={{
          position: "absolute",
          top: "50%",
          left: "50%",
          width: "100vw",
          height: "56.25vw",
          minHeight: "100%",
          minWidth: "177.78vh",
          transform: "translate(-50%, -50%)",
          objectFit: "cover",
        }}
      />
    </div>
  );
}
