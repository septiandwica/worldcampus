import React from 'react';
import { Globe, ShieldCheck, KeyRound, Sparkles, ArrowRight } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card } from '@/components/ui/card';

interface AuthScreenProps {
  wwwroot?: string;
  ssoUrl?: string;
  sitename?: string;
}

export const AuthScreen: React.FC<AuthScreenProps> = ({
  wwwroot = '',
  ssoUrl = '/auth/sso/login.php',
  sitename = 'President University World Campus',
}) => {
  return (
    <div className="min-h-screen flex flex-col lg:flex-row world-grid-bg">
      {/* Left Global Showcase */}
      <div className="hidden lg:flex lg:w-1/2 relative flex-col justify-between p-12 overflow-hidden border-r border-border-subtle bg-gradient-to-b from-navy-950/40 to-navy-900/40">
        <div className="absolute top-0 left-0 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none" />
        <div className="absolute bottom-0 right-0 w-96 h-96 bg-red/10 rounded-full blur-3xl pointer-events-none" />

        <div className="relative z-10">
          <a href={wwwroot || '/'} className="flex items-center gap-3">
            <div className="w-12 h-12 rounded-2xl bg-gradient-to-r from-navy-950 to-navy-800 flex items-center justify-center text-white shadow-xl ring-1 ring-cyan-500/30">
              <Globe className="w-7 h-7 text-cyan-400" />
            </div>
            <div>
              <span className="text-2xl font-black text-foreground">
                World<span className="bg-gradient-to-r from-cyan-400 to-red bg-clip-text text-transparent">Campus</span>
              </span>
              <p className="text-xs text-muted-foreground font-semibold">President Distance Learning Ecosystem</p>
            </div>
          </a>
        </div>

        <div className="relative z-10 my-auto space-y-6 max-w-lg">
          <Badge variant="cyan" className="gap-1.5">
            <span className="w-2 h-2 rounded-full bg-cyan-400 animate-ping" />
            Global Distance Learning Portal
          </Badge>

          <h1 className="text-4xl xl:text-5xl font-extrabold text-foreground tracking-tight leading-tight">
            Your Gateway to <br />
            <span className="bg-gradient-to-r from-cyan-400 via-indigo-400 to-red bg-clip-text text-transparent">
              World-Class Education
            </span>
          </h1>

          <p className="text-muted-foreground text-base leading-relaxed">
            Access interactive courses, collaborate with international cohorts, and accelerate your mastery with real-time AI learning support.
          </p>

          <div className="grid grid-cols-3 gap-4 pt-4">
            <Card className="p-4 text-center">
              <div className="text-xl font-extrabold text-foreground">45+</div>
              <div className="text-[11px] text-muted-foreground font-semibold uppercase mt-0.5">Countries</div>
            </Card>
            <Card className="p-4 text-center">
              <div className="text-xl font-extrabold text-cyan-400">100%</div>
              <div className="text-[11px] text-muted-foreground font-semibold uppercase mt-0.5">Digital Sync</div>
            </Card>
            <Card className="p-4 text-center">
              <div className="text-xl font-extrabold text-red">24/7</div>
              <div className="text-[11px] text-muted-foreground font-semibold uppercase mt-0.5">AI Copilot</div>
            </Card>
          </div>
        </div>

        <div className="relative z-10 text-xs text-muted-foreground">
          &copy; 2026 World Campus &bull; President University.
        </div>
      </div>

      {/* Right Login Action Container */}
      <div className="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
        <Card className="max-w-md w-full p-8 sm:p-10 shadow-2xl border-border-subtle">
          <div className="mb-6">
            <h2 className="text-2xl font-bold text-foreground">Sign In to Your Portal</h2>
            <p className="text-sm text-muted-foreground mt-1">
              Authenticate your identity to enter the digital campus
            </p>
          </div>

          {/* University SSO Button */}
          <div className="mb-6">
            <Button asChild size="lg" variant="primary" className="w-full shadow-lg shadow-cyan-500/20">
              <a href={ssoUrl}>
                <KeyRound className="w-5 h-5 mr-2" />
                Sign in with University SSO
              </a>
            </Button>
          </div>

          <div className="relative flex py-2 items-center mb-6">
            <div className="flex-grow border-t border-border-subtle" />
            <span className="flex-shrink mx-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
              or credentials
            </span>
            <div className="flex-grow border-t border-border-subtle" />
          </div>

          <div id="moodle-native-login-container" className="space-y-4">
            {/* Moodle native form is automatically injected here */}
          </div>

          <div className="mt-8 pt-6 border-t border-border-subtle text-center">
            <p className="text-xs text-muted-foreground">
              Need technical help?{' '}
              <a href="#" className="text-cyan-400 font-semibold hover:underline">
                Contact Campus Support
              </a>
            </p>
          </div>
        </Card>
      </div>
    </div>
  );
};
