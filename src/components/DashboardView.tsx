import React from 'react';
import { 
  Sparkles, 
  BookOpen, 
  CheckCircle2, 
  TrendingUp, 
  ArrowRight, 
  PlayCircle,
  GraduationCap
} from 'lucide-react';
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Progress } from '@/components/ui/progress';
import { Badge } from '@/components/ui/badge';

interface CourseItem {
  id: number;
  fullname: string;
  summary: string;
  progress: number;
  viewurl: string;
}

interface DashboardViewProps {
  wwwroot?: string;
  userFullname?: string;
  courseCount?: number;
  averageProgress?: number;
  courses?: CourseItem[];
}

export const DashboardView: React.FC<DashboardViewProps> = ({
  wwwroot = '',
  userFullname = 'Student',
  courseCount = 0,
  averageProgress = 0,
  courses = [],
}) => {
  return (
    <div className="space-y-8">
      {/* Welcome & AI Tutor Banner */}
      <Card className="p-6 sm:p-8 bg-gradient-to-br from-navy-950/90 via-navy-900/90 to-navy-950/90 border-cyan-500/20 shadow-2xl relative overflow-hidden">
        <div className="absolute top-0 right-0 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none" />
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div className="space-y-2">
            <Badge variant="cyan" className="gap-1.5">
              <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" />
              Active Academic Semester
            </Badge>
            <h1 className="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
              Welcome back, <span className="bg-gradient-to-r from-cyan-400 to-red bg-clip-text text-transparent">{userFullname}</span>
            </h1>
            <p className="text-sm text-slate-300 max-w-xl">
              Track your distance learning milestone, access interactive lecture modules, and review assignments.
            </p>
          </div>

          {/* Demi AI Tutor Card */}
          <div className="flex-shrink-0 p-4 rounded-2xl bg-gradient-to-r from-navy-800/80 to-navy-700/80 border border-cyan-500/30 flex items-center gap-4 shadow-lg shadow-navy-950/50">
            <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-400 to-red flex items-center justify-center text-white shadow-md">
              <Sparkles className="w-6 h-6" />
            </div>
            <div>
              <div className="text-[11px] font-bold text-cyan-300 uppercase tracking-wider">AI Learning Assistant</div>
              <div className="text-sm font-bold text-white">Ask Demi AI Tutor</div>
              <div className="text-xs text-slate-300">24/7 Intelligent Course Copilot</div>
            </div>
          </div>
        </div>
      </Card>

      {/* Metric Cards Grid */}
      <div className="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <Card className="p-6 flex items-center gap-4">
          <div className="w-12 h-12 rounded-xl bg-navy-800/60 border border-cyan-500/30 flex items-center justify-center text-cyan-400">
            <BookOpen className="w-6 h-6" />
          </div>
          <div>
            <div className="text-2xl font-extrabold text-foreground">{courseCount}</div>
            <div className="text-xs text-muted-foreground font-semibold">Enrolled Programs</div>
          </div>
        </Card>

        <Card className="p-6 flex items-center gap-4">
          <div className="w-12 h-12 rounded-xl bg-navy-800/60 border border-indigo-500/30 flex items-center justify-center text-indigo-400">
            <TrendingUp className="w-6 h-6" />
          </div>
          <div>
            <div className="text-2xl font-extrabold text-cyan-400">{averageProgress}%</div>
            <div className="text-xs text-muted-foreground font-semibold">Average Course Completion</div>
          </div>
        </Card>

        <Card className="p-6 flex items-center gap-4">
          <div className="w-12 h-12 rounded-xl bg-navy-800/60 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
            <CheckCircle2 className="w-6 h-6" />
          </div>
          <div>
            <div className="text-2xl font-extrabold text-emerald-400">Good Standing</div>
            <div className="text-xs text-muted-foreground font-semibold">Academic Status</div>
          </div>
        </Card>
      </div>

      {/* Active Courses Grid with Shadcn Cards */}
      <div className="space-y-4">
        <div className="flex items-center justify-between">
          <h2 className="text-xl font-bold text-foreground flex items-center gap-2">
            <GraduationCap className="w-5 h-5 text-cyan-400" />
            Active Learning Modules
          </h2>
          <Button asChild variant="link" size="sm">
            <a href={`${wwwroot}/my/courses.php`}>
              View All Courses &rarr;
            </a>
          </Button>
        </div>

        {courses && courses.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {courses.map((course) => (
              <Card key={course.id} className="flex flex-col justify-between hover:border-cyan-500/40 hover:-translate-y-1 transition-all group overflow-hidden">
                <CardHeader>
                  <div className="flex items-center justify-between mb-2">
                    <Badge variant="cyan">Degree Course</Badge>
                    <span className="text-xs font-bold text-cyan-400">{course.progress}%</span>
                  </div>
                  <CardTitle className="group-hover:text-cyan-400 transition-colors line-clamp-2">
                    {course.fullname}
                  </CardTitle>
                  <CardDescription className="line-clamp-2 mt-1">
                    {course.summary || 'Comprehensive online lecture series and weekly assignments.'}
                  </CardDescription>
                </CardHeader>

                <CardContent className="space-y-2">
                  <div className="flex justify-between text-xs text-muted-foreground font-medium">
                    <span>Progress</span>
                    <span>{course.progress}% Completed</span>
                  </div>
                  <Progress value={course.progress} />
                </CardContent>

                <CardFooter className="pt-3 border-t border-border-subtle bg-slate-900/20">
                  <Button asChild variant="default" size="sm" className="w-full">
                    <a href={course.viewurl}>
                      <PlayCircle className="w-4 h-4 mr-1.5" />
                      Continue Learning
                    </a>
                  </Button>
                </CardFooter>
              </Card>
            ))}
          </div>
        ) : (
          <Card className="p-12 text-center space-y-4">
            <BookOpen className="w-12 h-12 mx-auto text-muted-foreground opacity-50" />
            <h3 className="text-lg font-bold text-foreground">No active course enrollments</h3>
            <p className="text-xs text-muted-foreground max-w-sm mx-auto">
              Visit our course catalog to find degree programs and micro-courses that match your study plan.
            </p>
            <Button asChild variant="primary" size="sm">
              <a href={`${wwwroot}/course/index.php`}>Browse Courses</a>
            </Button>
          </Card>
        )}
      </div>
    </div>
  );
};
