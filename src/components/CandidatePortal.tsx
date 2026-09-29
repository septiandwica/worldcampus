import React, { useState } from 'react';
import { 
  GraduationCap, 
  CheckCircle2, 
  FileText, 
  Clock, 
  Sparkles, 
  Upload, 
  Download, 
  CreditCard, 
  HelpCircle,
  ArrowRight,
  ShieldCheck,
  UserCheck
} from 'lucide-react';
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from 
;
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Progress } from '@/components/ui/progress';
import { Tabs, TabsList, TabsTrigger, TabsContent } from '@/components/ui/tabs';

interface CandidatePortalProps {
  wwwroot?: string;
  candidateName?: string;
  applicationNumber?: string;
  selectedProgram?: string;
}

export const CandidatePortal: React.FC<CandidatePortalProps> = ({
  wwwroot = '',
  candidateName = 'Calon Mahasiswa',
  applicationNumber = 'PU-PJJ-2026-0892',
  selectedProgram = 'S1 Informatika (Distance Learning)',
}) => {
  const [admissionStep, setAdmissionStep] = useState(2); // 1: Registration, 2: Document Verification, 3: Academic Review, 4: LoA & Payment, 5: Enrolled

  const steps = [
    { id: 1, title: 'Formulir Pendaftaran', desc: 'Data Diri & Pilihan Prodi', status: 'completed' },
    { id: 2, title: 'Unggah Dokumen', desc: 'Ijazah & Transkrip Nilai', status: 'in_progress' },
    { id: 3, title: 'Verifikasi Akademik', desc: 'Evaluasi Portofolio / Nilai', status: 'pending' },
    { id: 4, title: 'Letter of Acceptance (LoA)', desc: 'Penerbitan Surat Diterima', status: 'pending' },
    { id: 5, title: 'Aktivasi Mahasiswa', desc: 'NIM & Akun Perkuliahan', status: 'pending' },
  ];

  return (
    <div className="space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      {/* Header Banner */}
      <Card className="p-6 sm:p-8 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950 border-cyan-500/20 text-white relative overflow-hidden shadow-2xl">
        <div className="absolute -right-16 -top-16 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none" />
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div className="space-y-2">
            <div className="flex items-center gap-2">
              <Badge variant="cyan" className="gap-1">
                <UserCheck className="w-3.5 h-3.5" />
                Portal Calon Mahasiswa Baru (PMB)
              </Badge>
              <span className="text-xs text-slate-400 font-mono">No. Reg: {applicationNumber}</span>
            </div>
            <h1 className="text-2xl sm:text-4xl font-black tracking-tight text-white">
              Halo, <span className="bg-gradient-to-r from-cyan-400 to-red bg-clip-text text-transparent">{candidateName}</span>
            </h1>
            <p className="text-sm text-slate-300 max-w-2xl leading-relaxed">
              Selamat datang di portal penerimaan mahasiswa baru President University World Campus. Pantau status berkas, ikuti tes penempatan, dan unduh Surat Penerimaan (LoA) Anda di sini.
            </p>
          </div>

          <div className="p-4 rounded-2xl bg-navy-800/80 border border-cyan-500/30 flex items-center gap-4 shrink-0 shadow-lg">
            <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-400 to-red flex items-center justify-center text-white shadow-md">
              <GraduationCap className="w-6 h-6" />
            </div>
            <div>
              <div className="text-[11px] font-bold text-cyan-300 uppercase tracking-wider">Program Pilihan</div>
              <div className="text-sm font-bold text-white">{selectedProgram}</div>
              <div className="text-xs text-emerald-400 font-semibold flex items-center gap-1 mt-0.5">
                <CheckCircle2 className="w-3 h-3" /> Gelombang Early Bird Aktif
              </div>
            </div>
          </div>
        </div>
      </Card>

      {/* Progress Timeline Stepper */}
      <Card className="p-6">
        <h2 className="text-base font-bold text-foreground mb-4 flex items-center gap-2">
          <Clock className="w-4 h-4 text-cyan-400" />
          Tahapan Penerimaan Mahasiswa Baru
        </h2>
        <div className="grid grid-cols-1 sm:grid-cols-5 gap-4">
          {steps.map((s, idx) => {
            const isCompleted = s.id < admissionStep;
            const isCurrent = s.id === admissionStep;

            return (
              <div
                key={s.id}
                className={`p-4 rounded-xl border transition-all ${
                  isCurrent
                    ? 'border-cyan-500/60 bg-cyan-500/10 shadow-md'
                    : isCompleted
                    ? 'border-emerald-500/40 bg-emerald-500/5'
                    : 'border-border-subtle bg-card opacity-60'
                }`}
              >
                <div className="flex items-center justify-between mb-2">
                  <span
                    className={`w-6 h-6 rounded-full text-xs font-bold flex items-center justify-center ${
                      isCompleted
                        ? 'bg-emerald-500 text-white'
                        : isCurrent
                        ? 'bg-cyan-500 text-white'
                        : 'bg-slate-700 text-slate-300'
                    }`}
                  >
                    {isCompleted ? '✓' : s.id}
                  </span>
                  <Badge variant={isCompleted ? 'emerald' : isCurrent ? 'cyan' : 'outline'}>
                    {isCompleted ? 'Selesai' : isCurrent ? 'Dalam Proses' : 'Menunggu'}
                  </Badge>
                </div>
                <div className="font-bold text-xs text-foreground mt-1">{s.title}</div>
                <div className="text-[11px] text-muted-foreground mt-0.5">{s.desc}</div>
              </div>
            );
          })}
        </div>
      </Card>

      {/* Main Tabbed Workflow */}
      <Tabs defaultValue="documents" className="space-y-6">
        <TabsList className="w-full sm:w-auto flex-wrap justify-start">
          <TabsTrigger value="documents">Berkas & Persyaratan</TabsTrigger>
          <TabsTrigger value="academic_test">Ujian Potensi / Wawancara</TabsTrigger>
          <TabsTrigger value="loa">Letter of Acceptance (LoA)</TabsTrigger>
          <TabsTrigger value="tuition">Biaya & Skema Pembayaran</TabsTrigger>
        </TabsList>

        {/* Tab 1: Documents Upload */}
        <TabsContent value="documents" className="space-y-4">
          <Card className="p-6 space-y-6">
            <div>
              <h3 className="text-lg font-bold text-foreground">Dokumen Persyaratan Calon Mahasiswa</h3>
              <p className="text-xs text-muted-foreground mt-1">
                Unggah salinan digital dokumen dalam format PDF atau JPG (Maks. 5MB per berkas).
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div className="p-4 rounded-xl border border-border-subtle bg-slate-900/20 flex items-center justify-between">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 rounded-lg bg-navy-800 flex items-center justify-center text-cyan-400">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <div className="text-xs font-bold text-foreground">Ijazah / SKL SMA/SMK</div>
                    <div className="text-[11px] text-emerald-400 font-semibold">✓ Terverifikasi</div>
                  </div>
                </div>
                <Button size="sm" variant="outline">Lihat Berkas</Button>
              </div>

              <div className="p-4 rounded-xl border border-cyan-500/40 bg-cyan-500/5 flex items-center justify-between">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 rounded-lg bg-cyan-500/20 flex items-center justify-center text-cyan-400">
                    <Upload className="w-5 h-5" />
                  </div>
                  <div>
                    <div className="text-xs font-bold text-foreground">Transkrip Nilai Terakhir</div>
                    <div className="text-[11px] text-cyan-400 font-semibold">Perlu Diunggah</div>
                  </div>
                </div>
                <Button size="sm" variant="primary">Unggah PDF</Button>
              </div>

              <div className="p-4 rounded-xl border border-border-subtle bg-slate-900/20 flex items-center justify-between">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 rounded-lg bg-navy-800 flex items-center justify-center text-indigo-400">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <div className="text-xs font-bold text-foreground">Kartu Tanda Penduduk (KTP / Paspor)</div>
                    <div className="text-[11px] text-emerald-400 font-semibold">✓ Terverifikasi</div>
                  </div>
                </div>
                <Button size="sm" variant="outline">Lihat Berkas</Button>
              </div>

              <div className="p-4 rounded-xl border border-border-subtle bg-slate-900/20 flex items-center justify-between">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 rounded-lg bg-navy-800 flex items-center justify-center text-amber-400">
                    <Upload className="w-5 h-5" />
                  </div>
                  <div>
                    <div className="text-xs font-bold text-foreground">Pas Foto Resmi (Background Merah/Biru)</div>
                    <div className="text-[11px] text-amber-400 font-semibold">Menunggu Review</div>
                  </div>
                </div>
                <Button size="sm" variant="outline">Ganti Foto</Button>
              </div>
            </div>
          </Card>
        </TabsContent>

        {/* Tab 2: Academic Review & Placement */}
        <TabsContent value="academic_test">
          <Card className="p-6 space-y-4">
            <h3 className="text-lg font-bold text-foreground">Assessment Potensi Akademik & Bahasa Inggris</h3>
            <p className="text-xs text-muted-foreground">
              Tes penempatan online diselenggarakan untuk menentukan tingkatan kelas dan rekomendasi mata kuliah awal Anda.
            </p>
            <div className="p-6 rounded-2xl bg-gradient-to-r from-navy-900 to-navy-800 text-white flex flex-col sm:flex-row items-center justify-between gap-4">
              <div>
                <Badge variant="cyan" className="mb-2">Online Assessment Ready</Badge>
                <h4 className="text-base font-bold">English Proficiency & Logic Placement Test</h4>
                <p className="text-xs text-slate-300 mt-1">Durasi: 45 Menit &bull; 50 Soal Pilihan Ganda &bull; AI Monitored</p>
              </div>
              <Button variant="primary" size="lg">
                Mulai Tes Sekarang &rarr;
              </Button>
            </div>
          </Card>
        </TabsContent>

        {/* Tab 3: LoA (Letter of Acceptance) */}
        <TabsContent value="loa">
          <Card className="p-6 space-y-4">
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div>
                <h3 className="text-lg font-bold text-foreground">Official Letter of Acceptance (LoA)</h3>
                <p className="text-xs text-muted-foreground mt-1">
                  Surat resmi penerimaan mahasiswa baru President University World Campus dengan QR Code validasi keaslian.
                </p>
              </div>
              <Button variant="primary" className="gap-2">
                <Download className="w-4 h-4" />
                Unduh PDF LoA Resmi
              </Button>
            </div>

            <div className="p-8 rounded-2xl border border-border-subtle bg-card text-foreground font-serif space-y-4 shadow-sm">
              <div className="border-b border-border-subtle pb-4 flex justify-between items-start">
                <div>
                  <h4 className="text-xl font-bold font-sans">PRESIDENT UNIVERSITY</h4>
                  <p className="text-xs font-sans text-muted-foreground">Office of Global Admissions & Distance Learning (PJJ)</p>
                </div>
                <Badge variant="emerald">ACCEPTED / DITERIMA</Badge>
              </div>
              <p className="text-xs leading-relaxed">
                Berdasarkan hasil evaluasi dokumen dan kualifikasi akademik, Rektorat President University dengan bangga menyatakan bahwa:
              </p>
              <div className="bg-slate-900/10 p-4 rounded-xl font-sans text-xs space-y-1">
                <div><strong>Nama Mahasiswa:</strong> {candidateName}</div>
                <div><strong>Nomor Pendaftaran:</strong> {applicationNumber}</div>
                <div><strong>Program Studi:</strong> {selectedProgram}</div>
                <div><strong>Tahun Akademik:</strong> 2026/2027 (Batch Ganjil)</div>
              </div>
              <p className="text-xs leading-relaxed">
                Telah resmi diterima sebagai Mahasiswa Baru Program Pendidikan Jarak Jauh (PJJ) President University.
              </p>
            </div>
          </Card>
        </TabsContent>

        {/* Tab 4: Tuition & Payment */}
        <TabsContent value="tuition">
          <Card className="p-6 space-y-6">
            <div>
              <h3 className="text-lg font-bold text-foreground">Rincian Biaya Kuliah & Skema Cicilan</h3>
              <p className="text-xs text-muted-foreground mt-1">
                Tersedia opsi pembayaran lunas per semester atau cicilan bulanan tanpa bunga (0%).
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              <Card className="p-6 border-cyan-500/40 relative">
                <Badge variant="cyan" className="mb-3">Skema Bulanan</Badge>
                <div className="text-2xl font-black text-foreground">Rp 1.250.000 <span className="text-xs font-normal text-muted-foreground">/ bulan</span></div>
                <p className="text-xs text-muted-foreground mt-2">Cicilan 6x per semester. Sangat fleksibel bagi mahasiswa sambil bekerja.</p>
                <Button variant="default" size="sm" className="w-full mt-6">Pilih Skema Ini</Button>
              </Card>

              <Card className="p-6 border-emerald-500/40 relative">
                <Badge variant="emerald" className="mb-3">Lunas Per Semester (Hemat 10%)</Badge>
                <div className="text-2xl font-black text-emerald-400">Rp 6.750.000 <span className="text-xs font-normal text-muted-foreground">/ semester</span></div>
                <p className="text-xs text-muted-foreground mt-2">Sudah termasuk biaya kuliah, akses AI Tutor, dan perpustakaan digital global.</p>
                <Button variant="primary" size="sm" className="w-full mt-6">Bayar Semester Ini</Button>
              </Card>

              <Card className="p-6 border-border-subtle">
                <Badge variant="outline" className="mb-3">Beasiswa Global Talent</Badge>
                <div className="text-2xl font-black text-foreground">Potongan s.d. 50%</div>
                <p className="text-xs text-muted-foreground mt-2">Ajukan jalur prestasi akademik atau portofolio kerja untuk potongan biaya.</p>
                <Button variant="outline" size="sm" className="w-full mt-6">Ajukan Beasiswa</Button>
              </Card>
            </div>
          </Card>
        </TabsContent>
      </Tabs>
    </div>
  );
};
