"use client"

import { useState } from "react"
import { Dashboard } from "@/components/dashboard"
import { LanguageSelector } from "@/components/language-selector"
import AnalyticsDashboard from "@/components/analytics-dashboard"
import BusinessSettings from "@/components/business-settings"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import type { Language } from "@/lib/i18n"
import { BarChart3, Settings, Wine, HomeIcon } from "lucide-react"

export default function Home() {
  const [currentLanguage, setCurrentLanguage] = useState<Language>("en")
  const [activeTab, setActiveTab] = useState("dashboard")

  return (
    <div className="min-h-screen bg-background">
      <header className="border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <div className="container flex h-14 items-center justify-between">
          <div className="flex items-center gap-2">
            <Wine className="w-6 h-6 text-purple-600" />
            <h1 className="text-xl font-bold">DigitalPP</h1>
            <span className="text-sm text-muted-foreground">Wine QR Label Generator</span>
          </div>
          <LanguageSelector currentLanguage={currentLanguage} onLanguageChange={setCurrentLanguage} />
        </div>
      </header>

      <div className="container mx-auto py-6">
        <Tabs value={activeTab} onValueChange={setActiveTab} className="w-full">
          <TabsList className="grid w-full grid-cols-4 mb-6">
            <TabsTrigger value="dashboard" className="flex items-center gap-2">
              <HomeIcon className="w-4 h-4" />
              Dashboard
            </TabsTrigger>
            <TabsTrigger value="labels" className="flex items-center gap-2">
              <Wine className="w-4 h-4" />
              Wine Labels
            </TabsTrigger>
            <TabsTrigger value="analytics" className="flex items-center gap-2">
              <BarChart3 className="w-4 h-4" />
              Analytics
            </TabsTrigger>
            <TabsTrigger value="settings" className="flex items-center gap-2">
              <Settings className="w-4 h-4" />
              Settings
            </TabsTrigger>
          </TabsList>

          <TabsContent value="dashboard">
            <Dashboard language={currentLanguage} />
          </TabsContent>

          <TabsContent value="labels">
            <Dashboard language={currentLanguage} />
          </TabsContent>

          <TabsContent value="analytics">
            <AnalyticsDashboard language={currentLanguage} />
          </TabsContent>

          <TabsContent value="settings">
            <BusinessSettings language={currentLanguage} />
          </TabsContent>
        </Tabs>
      </div>
    </div>
  )
}
