"use client";

import { useEffect, useRef } from "react";

export default function HeroVideo() {
  const videoRef = useRef<HTMLVideoElement>(null);

  useEffect(() => {
    const video = videoRef.current;
    if (!video) return;

    const src = "/assets/video/hero-desktop.mp4";

    // muted via JS é obrigatório para autoplay no iOS Safari
    video.muted = true;
    video.playsInline = true;

    // Atribui src e chama load() explicitamente — Android Chrome não reinicia
    // o buffer automaticamente quando src muda sem load().
    video.src = src;
    video.load();

    let resumeTimer: ReturnType<typeof setTimeout> | null = null;
    let isPlaying = false;

    const tryPlay = () => {
      if (resumeTimer) clearTimeout(resumeTimer);
      const p = video.play();
      if (p && typeof p.catch === "function") p.catch(() => {});
    };

    const onPlaying = () => { isPlaying = true; };
    video.addEventListener("playing", onPlaying);

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

    // Fallback para iOS: quando o usuário volta de /ao-vivo após interagir com
    // o player do YouTube, o iOS mantém uma audio session ativa que bloqueia
    // o autoplay silenciosamente (play() rejeita sem disparar erro visível).
    // Se o vídeo não entrou em "playing" em 1.5s, aguarda o primeiro gesto do
    // usuário — iOS sempre permite mídia muted em resposta a interação.
    const onFirstInteraction = () => { if (!isPlaying) tryPlay(); };
    const fallbackTimer = setTimeout(() => {
      if (!isPlaying) {
        document.addEventListener("touchstart", onFirstInteraction, { passive: true, once: true });
        document.addEventListener("click", onFirstInteraction, { once: true });
      }
    }, 1500);

    return () => {
      if (resumeTimer) clearTimeout(resumeTimer);
      clearTimeout(fallbackTimer);
      video.removeEventListener("playing", onPlaying);
      video.removeEventListener("canplay", onCanPlay);
      video.removeEventListener("loadeddata", onLoadedData);
      video.removeEventListener("loadedmetadata", onLoadedMetadata);
      video.removeEventListener("pause", onPause);
      document.removeEventListener("visibilitychange", onVisibility);
      window.removeEventListener("pageshow", onPageShow);
      document.removeEventListener("touchstart", onFirstInteraction);
      document.removeEventListener("click", onFirstInteraction);
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
