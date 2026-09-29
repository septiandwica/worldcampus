import React from 'react';
import { Globe, BookOpen, Users, Award, Sparkles, ArrowRight, ShieldCheck } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card } from '@/components/ui/card';

interface FrontpageHeroProps {
  wwwroot?: string;
  herotitle?: string;
  herosubtitle?: string;
  herobuttontext?: string;
  herobuttonurl?: string;
  isLoggedIn?: boolean;
}

export const FrontpageHero: React.FC<FrontpageHeroProps> = ({
  wwwroot = '',
  herotitle = 'Empowering Minds Across the Globe',
  herosubtitle = 'Experience world-class online learning with interactive digital classrooms, AI-assisted tutoring, and flexible study pathways.',
  herobuttontext = 'Explore Global Courses',
  herobuttonurl = '/course/index.php',
  isLoggedIn = false,
}) => {
  return (
    <div className="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-32 world-grid-bg">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div className="text-center max-w-3xl mx-auto space-y-6">
          <Badge variant="cyan" className="px-3.5 py-1.5 gap-2 text-xs font-semibold">
            <span className="w-2 h-2 rounded-full bg-cyan-400 animate-ping" />
            President University &bull; Distance Learning Global Campus
          </Badge>

          <h1 className="text-4xl sm:text-6xl font-extrabold text-foreground tracking-tight leading-tight">
            {herotitle.includes('Across') ? (
              <>
                {herotitle.split('Across')[0]} <br />
                <span className="bg-gradient-to-r from-cyan-400 via-indigo-400 to-red bg-clip-text text-transparent">
                  Across{herotitle.split('Across')[1]}
                </span>
              </>
            ) : (
              <span className="bg-gradient-to-r from-cyan-400 to-red bg-clip-text text-transparent">
                {herotitle}
              </span>
            )}
          </h1>

          <p className="text-base sm:text-lg text-muted-foreground max-w-2xl mx-auto leading-relaxed">
            {herosubtitle}
          </p>

          <div className="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <Button asChild size="lg" variant="primary" className="w-full sm:w-auto shadow-xl shadow-cyan-500/20">
              <a href={herobuttonurl.startsWith('http') ? herobuttonurl : `${wwwroot}${herobuttonurl}`}>
                {herobuttontext}
                <ArrowRight className="w-4 h-4 ml-1" />
              </a>
            </Button>
            {!isLoggedIn && (
              <Button asChild size="lg" variant="outline" className="w-full sm:w-auto">
                <a href={`${wwwroot}/login/index.php`}>
                  Student Login
                </a>
              </Button>
            )}
          </div>
        </div>

        {/* Global Telemetry Metric Cards */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mt-16 max-w-5xl mx-auto">
          <Card className="p-6 text-center border-border-subtle hover:border-cyan-500/40 transition-all">
            <div className="w-10 h-10 mx-auto mb-2 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-400">
              <Users className="w-5 h-5" />
            </div>
            <div className="text-2xl sm:text-3xl font-extrabold text-foreground">12,500+</div>
            <div className="text-xs text-muted-foreground font-semibold uppercase mt-0.5">Active Students</div>
          </Card>

          <Card className="p-6 text-center border-border-subtle hover:border-indigo-500/40 transition-all">
            <div className="w-10 h-10 mx-auto mb-2 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400">
              <Globe className="w-5 h-5" />
            </div>
            <div className="text-2xl sm:text-3xl font-extrabold text-cyan-400">45+</div>
            <div className="text-xs text-muted-foreground font-semibold uppercase mt-0.5">Partner Countries</div>
          </Card>

          <Card className="p-6 text-center border-border-subtle hover:border-red/40 transition-all">
            <div className="w-10 h-10 mx-auto mb-2 rounded-xl bg-red/10 flex items-center justify-center text-red">
              <BookOpen className="w-5 h-5" />
            </div>
            <div className="text-2xl sm:text-3xl font-extrabold text-foreground">180+</div>
            <div className="text-xs text-muted-foreground font-semibold uppercase mt-0.5">Accredited Modules</div>
          </Card>

          <Card className="p-6 text-center border-border-subtle hover:border-emerald-500/40 transition-all">
            <div className="w-10 h-10 mx-auto mb-2 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
              <Sparkles className="w-5 h-5" />
            </div>
            <div className="text-2xl sm:text-3xl font-extrabold text-emerald-400">24/7</div>
            <div className="text-xs text-muted-foreground font-semibold uppercase mt-0.5">Demi AI Tutor</div>
          </Card>
        </div>
      </div>
    </div>
  );
};
