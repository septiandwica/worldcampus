import React, { useState } from 'react';
import { Search, Star, PlayCircle, BookOpen, Filter, CheckCircle2, Clock } from 'lucide-react';
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { Progress } from '@/components/ui/progress';
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs';

interface CourseData {
  id: number;
  fullname: string;
  summary: string;
  progress: number;
  is_completed?: boolean;
  viewurl: string;
  category?: string;
  isFavourite?: boolean;
}

interface CourseCatalogProps {
  wwwroot?: string;
  courses?: CourseData[];
  courseCount?: number;
}

export const CourseCatalog: React.FC<CourseCatalogProps> = ({
  wwwroot = '',
  courses = [],
  courseCount = 0,
}) => {
  const [searchTerm, setSearchTerm] = useState('');
  const [activeTab, setActiveTab] = useState('all');
  const [favouriteIds, setFavouriteIds] = useState<number[]>([]);

  const toggleFavourite = (id: number) => {
    setFavouriteIds((prev) =>
      prev.includes(id) ? prev.filter((item) => item !== id) : [...prev, id]
    );
  };

  const filteredCourses = courses.filter((c) => {
    const matchesSearch = c.fullname.toLowerCase().includes(searchTerm.toLowerCase()) ||
                          c.summary.toLowerCase().includes(searchTerm.toLowerCase());
    if (!matchesSearch) return false;

    if (activeTab === 'in_progress') return (c.progress || 0) < 100;
    if (activeTab === 'completed') return (c.progress || 0) >= 100 || c.is_completed;
    if (activeTab === 'favourites') return favouriteIds.includes(c.id);
    return true;
  });

  return (
    <div className="space-y-6">
      {/* Header Bar */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-border-subtle pb-6">
        <div>
          <h1 className="text-2xl sm:text-3xl font-extrabold text-foreground tracking-tight">
            My Enrolled Courses
          </h1>
          <p className="text-sm text-muted-foreground mt-1">
            Manage your distance learning progress across active modules ({courses.length} courses)
          </p>
        </div>

        {/* Search & Filter Bar */}
        <div className="flex items-center gap-3 w-full md:w-auto">
          <div className="relative w-full md:w-64">
            <Search className="w-4 h-4 text-muted-foreground absolute left-3 top-3" />
            <Input
              placeholder="Search courses..."
              className="pl-9"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
          </div>
        </div>
      </div>

      {/* Filter Tabs */}
      <div className="flex flex-wrap items-center justify-between gap-4">
        <Tabs value={activeTab} onValueChange={setActiveTab}>
          <TabsList>
            <TabsTrigger value="all">All Courses ({courses.length})</TabsTrigger>
            <TabsTrigger value="in_progress">In Progress</TabsTrigger>
            <TabsTrigger value="completed">Completed</TabsTrigger>
            <TabsTrigger value="favourites">Starred ({favouriteIds.length})</TabsTrigger>
          </TabsList>
        </Tabs>
      </div>

      {/* Course Cards Grid */}
      {filteredCourses.length > 0 ? (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredCourses.map((course) => {
            const isFav = favouriteIds.includes(course.id);
            const isCompleted = (course.progress || 0) >= 100 || course.is_completed;

            return (
              <Card
                key={course.id}
                className="flex flex-col justify-between hover:border-cyan-500/40 hover:-translate-y-1 transition-all group overflow-hidden"
              >
                <div>
                  {/* Card Banner */}
                  <div className="h-36 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 p-4 flex flex-col justify-between relative">
                    <div className="flex items-center justify-between z-10">
                      <Badge variant={isCompleted ? 'emerald' : 'cyan'}>
                        {isCompleted ? 'Completed' : 'In Progress'}
                      </Badge>
                      <button
                        type="button"
                        onClick={() => toggleFavourite(course.id)}
                        className="p-1.5 rounded-full bg-slate-900/60 backdrop-blur-sm hover:scale-110 transition-all text-amber-400"
                        title="Star Course"
                      >
                        <Star className={`w-4 h-4 ${isFav ? 'fill-amber-400' : 'text-slate-400'}`} />
                      </button>
                    </div>
                    <div className="z-10">
                      <span className="text-[10px] font-bold text-cyan-300 uppercase tracking-wider">
                        Online Degree Program
                      </span>
                    </div>
                    <div className="absolute inset-0 bg-gradient-to-t from-navy-950/90 to-transparent pointer-events-none" />
                  </div>

                  <CardHeader className="pt-4">
                    <CardTitle className="group-hover:text-cyan-400 transition-colors line-clamp-2 text-base">
                      {course.fullname}
                    </CardTitle>
                    <CardDescription className="line-clamp-2 mt-1">
                      {course.summary || 'Interactive curriculum designed for global distance learning.'}
                    </CardDescription>
                  </CardHeader>
                </div>

                <div className="space-y-3 p-6 pt-0">
                  <div className="space-y-1.5">
                    <div className="flex justify-between text-xs font-semibold text-muted-foreground">
                      <span>Completion</span>
                      <span className="text-cyan-400">{course.progress || 0}%</span>
                    </div>
                    <Progress value={course.progress || 0} />
                  </div>

                  <Button asChild variant="primary" size="sm" className="w-full">
                    <a href={course.viewurl}>
                      <PlayCircle className="w-4 h-4 mr-1.5" />
                      Enter Classroom &rarr;
                    </a>
                  </Button>
                </div>
              </Card>
            );
          })}
        </div>
      ) : (
        <Card className="p-12 text-center space-y-4">
          <BookOpen className="w-12 h-12 mx-auto text-muted-foreground opacity-50" />
          <h3 className="text-lg font-bold text-foreground">No courses match your filter</h3>
          <p className="text-xs text-muted-foreground max-w-sm mx-auto">
            Try adjusting your search query or switch back to the "All Courses" tab.
          </p>
          <Button variant="outline" size="sm" onClick={() => { setSearchTerm(''); setActiveTab('all'); }}>
            Reset Filters
          </Button>
        </Card>
      )}
    </div>
  );
};
