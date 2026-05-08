"use client";

import { useEffect, useRef } from "react";

export default function HeroVideo() {
  const videoRef = useRef<HTMLVideoElement>(null);

  useEffect(() => {
    const video = videoRef.current;
    if (!video) return;

    const isMobile = window.matchMedia("(max-width: 767px)").matches;
    const src = isMobile
      ? "/assets/video/hero-mobile.mp4"
      : "/assets/video/hero-desktop.mp4";

    // muted via JS é obrigatório para autoplay no iOS Safari
    video.muted = true;
    video.playsInline = true;

    // Atribui src e chama load() explicitamente — Android Chrome não reinicia
    // o buffer automaticamente quando src muda sem load().
    video.src = src;
    video.load();

    let resumeTimer: ReturnType<typeof setTimeout> | null = null;

    const tryPlay = () => {
      if (resumeTimer) clearTimeout(resumeTimer);
      const p = video.play();
      if (p && typeof p.catch === "function") p.catch(() => {});
    };

    const onCanPlay = () => tryPlay();
    const onLoadedData = () => tryPlay();
    const onLoadedMetadata = () => tryPlay();
    video.addEventListener("canplay", onCanPlay);
    video.addEventListener("loadeddata", onLoadedData);
    video.addEventListener("loadedmetadata", onLoadedMetadata);

    // Pause inesperado (low-power mode, perda de foco) — auto-resume com
    // delay de 300 ms para não brigar com o motor do browser no iOS.
    const onPause = () => {
      if (document.visibilityState !== "visible") return;
      resumeTimer = setTimeout(tryPlay, 300);
    };
    video.addEventListener("pause", onPause);

    const onVisibility = () => {
      if (document.visibilityState === "visible") tryPlay();
    };
    document.addEventListener("visibilitychange", onVisibility);

    // bfcache: vídeo pode estar pausado ao voltar pelo botão "voltar"
    const onPageShow = (e: PageTransitionEvent) => {
      if (e.persisted) {
        // re-carrega o src para garantir que o buffer foi retomado
        video.load();
      }
      tryPlay();
    };
    window.addEventListener("pageshow", onPageShow);

    return () => {
      if (resumeTimer) clearTimeout(resumeTimer);
      video.removeEventListener("canplay", onCanPlay);
      video.removeEventListener("loadeddata", onLoadedData);
      video.removeEventListener("loadedmetadata", onLoadedMetadata);
      video.removeEventListener("pause", onPause);
      document.removeEventListener("visibilitychange", onVisibility);
      window.removeEventListener("pageshow", onPageShow);
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
        preload="metadata"
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
