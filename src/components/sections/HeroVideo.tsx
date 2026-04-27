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
    video.playsInline = true;

    let userPaused = false; // só respeita pause se foi o usuário (sem fallback aqui)

    const tryPlay = () => {
      if (userPaused) return;
      const p = video.play();
      if (p && typeof p.catch === "function") p.catch(() => {});
    };

    // Tenta imediatamente — browser faz fila até ter dados suficientes
    tryPlay();

    // Triggers de retry: cobrem readyState insuficiente, conexão lenta, e bfcache
    const onCanPlay = () => tryPlay();
    const onLoadedData = () => tryPlay();
    const onLoadedMetadata = () => tryPlay();
    video.addEventListener("canplay", onCanPlay);
    video.addEventListener("loadeddata", onLoadedData);
    video.addEventListener("loadedmetadata", onLoadedMetadata);

    // Pause inesperado (low power, perda de foco breve) — auto-resume
    const onPause = () => {
      // Heurística: se a página está visível e não foi ação do usuário,
      // o pause veio do sistema. Tentamos retomar.
      if (document.visibilityState === "visible" && !userPaused) {
        // pequeno delay para não brigar com o próprio motor do browser
        setTimeout(tryPlay, 50);
      }
    };
    video.addEventListener("pause", onPause);

    // Retoma quando a aba volta a ficar visível
    const onVisibility = () => {
      if (document.visibilityState === "visible") tryPlay();
    };
    document.addEventListener("visibilitychange", onVisibility);

    // bfcache: ao voltar via botão "voltar" do navegador, o vídeo é restaurado
    // mas pode estar pausado e sem disparar canplay/loadeddata.
    const onPageShow = (e: PageTransitionEvent) => {
      if (e.persisted) tryPlay();
      else tryPlay(); // navegação normal — também tenta (idempotente)
    };
    window.addEventListener("pageshow", onPageShow);

    return () => {
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
