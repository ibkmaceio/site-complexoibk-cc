interface Window {
  YT: typeof YT;
  onYouTubeIframeAPIReady?: () => void;
}

declare namespace YT {
  enum PlayerState {
    UNSTARTED = -1,
    ENDED = 0,
    PLAYING = 1,
    PAUSED = 2,
    BUFFERING = 3,
    CUED = 5,
  }

  interface PlayerEvent {
    target: Player;
  }

  interface OnStateChangeEvent {
    target: Player;
    data: number;
  }

  interface PlayerVars {
    autoplay?: number;
    mute?: number;
    loop?: number;
    playlist?: string;
    controls?: number;
    showinfo?: number;
    rel?: number;
    modestbranding?: number;
    playsinline?: number;
    disablekb?: number;
    iv_load_policy?: number;
    origin?: string;
  }

  interface PlayerOptions {
    videoId: string;
    playerVars?: PlayerVars;
    events?: {
      onReady?: (event: PlayerEvent) => void;
      onStateChange?: (event: OnStateChangeEvent) => void;
    };
  }

  class Player {
    constructor(element: HTMLElement | string, options: PlayerOptions);
    playVideo(): void;
    pauseVideo(): void;
    mute(): void;
    unMute(): void;
    destroy(): void;
    getPlayerState(): number;
  }
}
