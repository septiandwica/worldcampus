import React, { useState, useEffect } from 'react';
import { 
  Globe, 
  LayoutDashboard, 
  BookOpen, 
  Search, 
  Sun, 
  Moon, 
  Menu, 
  User, 
  GraduationCap, 
  Settings, 
  LogOut, 
  Bell,
  Sparkles
} from 'lucide-react';
import { Button } from '@/components/ui/button';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';

interface NavbarProps {
  wwwroot?: string;
  sitename?: string;
  userFullname?: string;
  userEmail?: string;
  userAvatar?: string;
  isLoggedIn?: boolean;
  sesskey?: string;
}

export const Navbar: React.FC<NavbarProps> = ({
  wwwroot = '',
  sitename = 'World Campus',
  userFullname = 'Guest User',
  userEmail = '',
  userAvatar = '',
  isLoggedIn = false,
  sesskey = '',
}) => {
  const [theme, setTheme] = useState<'light' | 'dark'>('dark');

  useEffect(() => {
    const savedTheme = (localStorage.getItem('worldcampus_theme') as 'light' | 'dark') || 'dark';
    setTheme(savedTheme);
    document.documentElement.setAttribute('data-theme', savedTheme);
    if (savedTheme === 'dark') {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  }, []);

  const toggleTheme = () => {
    const nextTheme = theme === 'dark' ? 'light' : 'dark';
    setTheme(nextTheme);
    document.documentElement.setAttribute('data-theme', nextTheme);
    if (nextTheme === 'dark') {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
    localStorage.setItem('worldcampus_theme', nextTheme);
  };

  return (
    <header className="sticky top-0 z-40 w-full border-b border-border-subtle bg-navbar backdrop-blur-xl transition-all">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Brand / Logo & Mobile Trigger */}
          <div className="flex items-center gap-3">
            <Sheet>
              <SheetTrigger asChild>
                <Button variant="ghost" size="icon" className="md:hidden">
                  <Menu className="w-5 h-5 text-foreground" />
                </Button>
              </SheetTrigger>
              <SheetContent side="left" className="w-72">
                <SheetHeader className="mb-6">
                  <SheetTitle className="flex items-center gap-2">
                    <div className="w-8 h-8 rounded-lg bg-gradient-to-r from-navy-900 to-navy-800 flex items-center justify-center text-white">
                      <Globe className="w-5 h-5" />
                    </div>
                    <span>World<span className="text-cyan-400">Campus</span></span>
                  </SheetTitle>
                </SheetHeader>
                <nav className="flex flex-col space-y-2">
                  <a href={`${wwwroot}/my/`} className="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800/60">
                    <LayoutDashboard className="w-4 h-4 text-cyan-400" />
                    Dashboard
                  </a>
                  <a href={`${wwwroot}/my/courses.php`} className="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800/60">
                    <BookOpen className="w-4 h-4 text-indigo-400" />
                    My Courses
                  </a>
                  <a href={`${wwwroot}/course/index.php`} className="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800/60">
                    <Search className="w-4 h-4 text-emerald-400" />
                    Course Catalog
                  </a>
                </nav>
              </SheetContent>
            </Sheet>

            <a href={wwwroot || '/'} className="flex items-center gap-3 group">
              <div className="w-10 h-10 rounded-xl bg-gradient-to-r from-navy-950 to-navy-800 flex items-center justify-center text-white shadow-md ring-1 ring-cyan-500/30 group-hover:scale-105 transition-all">
                <Globe className="w-5 h-5 text-cyan-400" />
              </div>
              <div className="flex flex-col">
                <span className="text-lg font-extrabold tracking-tight text-foreground flex items-center gap-1">
                  World<span className="bg-gradient-to-r from-cyan-400 to-red bg-clip-text text-transparent">Campus</span>
                </span>
                <span className="text-[10px] text-muted-foreground font-semibold tracking-wider uppercase">Global Digital University</span>
              </div>
            </a>
          </div>

          {/* Desktop Nav Links */}
          <nav className="hidden md:flex items-center gap-1.5">
            <a href={`${wwwroot}/my/`} className="px-3.5 py-2 rounded-xl text-sm font-semibold text-muted-foreground hover:text-foreground hover:bg-slate-800/40 transition-all flex items-center gap-2">
              <LayoutDashboard className="w-4 h-4 text-cyan-400" />
              Dashboard
            </a>
            <a href={`${wwwroot}/my/courses.php`} className="px-3.5 py-2 rounded-xl text-sm font-semibold text-muted-foreground hover:text-foreground hover:bg-slate-800/40 transition-all flex items-center gap-2">
              <BookOpen className="w-4 h-4 text-indigo-400" />
              My Courses
            </a>
            <a href={`${wwwroot}/course/index.php`} className="px-3.5 py-2 rounded-xl text-sm font-semibold text-muted-foreground hover:text-foreground hover:bg-slate-800/40 transition-all flex items-center gap-2">
              <Search className="w-4 h-4 text-emerald-400" />
              Catalog
            </a>
          </nav>

          {/* Right Action Tools: AI Shortcut, Theme Toggle, User Profile */}
          <div className="flex items-center gap-2.5">
            <Button
              variant="outline"
              size="icon"
              onClick={toggleTheme}
              className="rounded-xl border-border-subtle"
              title="Toggle Theme"
            >
              {theme === 'dark' ? (
                <Sun className="w-4 h-4 text-amber-400" />
              ) : (
                <Moon className="w-4 h-4 text-indigo-600" />
              )}
            </Button>

            {isLoggedIn ? (
              <DropdownMenu>
                <DropdownMenuTrigger asChild>
                  <Button variant="ghost" className="flex items-center gap-2.5 p-1 rounded-xl hover:bg-slate-800/40 focus:outline-none">
                    <Avatar className="w-8 h-8 rounded-lg">
                      <AvatarImage src={userAvatar} alt={userFullname} />
                      <AvatarFallback>{userFullname.charAt(0)}</AvatarFallback>
                    </Avatar>
                    <div className="hidden lg:flex flex-col text-left">
                      <span className="text-xs font-bold text-foreground leading-tight">{userFullname}</span>
                      <span className="text-[10px] text-cyan-400 font-medium">Student</span>
                    </div>
                  </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end" className="w-56">
                  <DropdownMenuLabel>
                    <div className="text-xs font-bold text-foreground">{userFullname}</div>
                    <div className="text-[11px] text-muted-foreground truncate">{userEmail}</div>
                  </DropdownMenuLabel>
                  <DropdownMenuSeparator />
                  <DropdownMenuItem asChild>
                    <a href={`${wwwroot}/user/profile.php`}>
                      <User className="w-4 h-4 text-cyan-400 mr-2" />
                      My Profile
                    </a>
                  </DropdownMenuItem>
                  <DropdownMenuItem asChild>
                    <a href={`${wwwroot}/grade/report/overview/index.php`}>
                      <GraduationCap className="w-4 h-4 text-indigo-400 mr-2" />
                      Grades & Transcript
                    </a>
                  </DropdownMenuItem>
                  <DropdownMenuItem asChild>
                    <a href={`${wwwroot}/user/preferences.php`}>
                      <Settings className="w-4 h-4 text-slate-400 mr-2" />
                      Preferences
                    </a>
                  </DropdownMenuItem>
                  <DropdownMenuSeparator />
                  <DropdownMenuItem asChild className="text-rose-400 hover:text-rose-300">
                    <a href={`${wwwroot}/login/logout.php?sesskey=${sesskey}`}>
                      <LogOut className="w-4 h-4 mr-2" />
                      Log Out
                    </a>
                  </DropdownMenuItem>
                </DropdownMenuContent>
              </DropdownMenu>
            ) : (
              <Button asChild variant="primary" size="sm">
                <a href={`${wwwroot}/login/index.php`}>Sign In</a>
              </Button>
            )}
          </div>
        </div>
      </div>
    </header>
  );
};
