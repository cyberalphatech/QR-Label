"use client"

import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { useTranslation } from "@/lib/i18n"
import {
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  PieChart,
  Pie,
  Cell,
  LineChart,
  Line,
} from "recharts"

interface AnalyticsDashboardProps {
  language: string
}

const COLORS = ["#4285F4", "#FF6D00", "#3B3B3B", "#00A651"]

const platformData = [
  { name: "Windows", value: 50 },
  { name: "AndroidOS", value: 40 },
  { name: "Other", value: 10 },
]

const weeklyData = [
  { day: "Mon", viewsA: 20, viewsB: 10 },
  { day: "Tue", viewsA: 10, viewsB: 5 },
  { day: "Wed", viewsA: 5, viewsB: 2 },
  { day: "Thu", viewsA: 0, viewsB: 0 },
  { day: "Fri", viewsA: 0, viewsB: 0 },
  { day: "Sat", viewsA: 0, viewsB: 0 },
  { day: "Sun", viewsA: 0, viewsB: 0 },
]

const monthlyData = [
  { month: "Jan", vCard: 0, Negozi: 0 },
  { month: "Feb", vCard: 0, Negozi: 0 },
  { month: "Mar", vCard: 0, Negozi: 0 },
  { month: "Apr", vCard: 0, Negozi: 0 },
  { month: "May", vCard: 0, Negozi: 0 },
  { month: "Jun", vCard: 0, Negozi: 0 },
  { month: "Jul", vCard: 0, Negozi: 0 },
  { month: "Aug", vCard: 0, Negozi: 0 },
  { month: "Sep", vCard: 0, Negozi: 0 },
  { month: "Oct", vCard: 3, Negozi: 1 },
  { month: "Nov", vCard: 2, Negozi: 0.5 },
  { month: "Dec", vCard: 0, Negozi: 0 },
]

const topLabels = [
  { name: "/bit-solutions-ou-shop", visitors: 22 },
  { name: "/bit-solutions-ou", visitors: 18 },
]

export default function AnalyticsDashboard({ language }: AnalyticsDashboardProps) {
  const { t } = useTranslation(language)

  return (
    <div className="space-y-6">
      {/* Top Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
        <Card className="bg-white border border-gray-200 shadow-sm">
          <CardContent className="p-4">
            <div className="space-y-2">
              <p className="text-lg font-medium text-gray-600">ACTUAL PLAN</p>
              <p className="text-2xl font-bold text-gray-900">INTERMEDIO</p>
              <Button variant="link" className="p-0 h-auto text-blue-600 text-sm">
                Mostra dettagli
              </Button>
            </div>
          </CardContent>
        </Card>

        <Card className="bg-white border border-gray-200 shadow-sm">
          <CardContent className="p-4">
            <div className="space-y-2">
              <p className="text-lg font-medium text-gray-600">VIRTUAL LABELS</p>
              <p className="text-2xl font-bold text-gray-900">3</p>
              <Button variant="link" className="p-0 h-auto text-blue-600 text-sm">
                Mostra dettagli
              </Button>
            </div>
          </CardContent>
        </Card>

        <Card className="bg-white border border-gray-200 shadow-sm">
          <CardContent className="p-4">
            <div className="space-y-2">
              <p className="text-lg font-medium text-gray-600"></p>
              <p className="text-2xl font-bold text-gray-900"></p>
              <Button variant="link" className="p-0 h-auto text-blue-600 text-sm">
                Mostra dettagli
              </Button>
            </div>
          </CardContent>
        </Card>

        <Card className="bg-white border border-gray-200 shadow-sm">
          <CardContent className="p-4">
            <div className="space-y-2">
              <p className="text-lg font-medium text-gray-600"></p>
              <p className="text-2xl font-bold text-gray-900"></p>
              <Button variant="link" className="p-0 h-auto text-blue-600 text-sm">
                Mostra dettagli
              </Button>
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Charts Row */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Platform OS Chart */}
        <Card className="lg:col-span-2 bg-white">
          <CardHeader>
            <CardTitle className="text-lg font-semibold">PLATFORMS OS</CardTitle>
          </CardHeader>
          <CardContent>
            <ResponsiveContainer width="100%" height={300}>
              <LineChart data={monthlyData}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="month" />
                <YAxis />
                <Tooltip />
                <Line type="monotone" dataKey="vCard" stroke="#FF6D00" strokeWidth={2} />
                <Line type="monotone" dataKey="Negozi" stroke="#00A651" strokeWidth={2} />
              </LineChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>

        {/* Overview Pie Chart */}
        <Card className="bg-white">
          <CardHeader>
            <CardTitle className="text-lg font-semibold">PANORAMICA</CardTitle>
          </CardHeader>
          <CardContent>
            <ResponsiveContainer width="100%" height={300}>
              <PieChart>
                <Pie
                  data={platformData}
                  cx="50%"
                  cy="50%"
                  innerRadius={60}
                  outerRadius={100}
                  paddingAngle={5}
                  dataKey="value"
                >
                  {platformData.map((entry, index) => (
                    <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
                  ))}
                </Pie>
                <Tooltip />
              </PieChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>
      </div>

      {/* Bottom Charts Row */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Weekly Labels Views */}
        <Card className="lg:col-span-1 bg-white">
          <CardHeader>
            <CardTitle className="text-lg font-semibold">WEEKLY LABELS VIEWS</CardTitle>
          </CardHeader>
          <CardContent>
            <ResponsiveContainer width="100%" height={250}>
              <LineChart data={weeklyData}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="day" />
                <YAxis />
                <Tooltip />
                <Line type="monotone" dataKey="viewsA" stroke="#FF6D00" fill="rgba(255, 109, 0, 0.2)" />
                <Line type="monotone" dataKey="viewsB" stroke="#4285F4" fill="rgba(66, 133, 244, 0.2)" />
              </LineChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>

        {/* Views by Labels */}
        <Card className="bg-white">
          <CardHeader>
            <CardTitle className="text-lg font-semibold">VIEWS BY LABELS</CardTitle>
          </CardHeader>
          <CardContent>
            <ResponsiveContainer width="100%" height={250}>
              <PieChart>
                <Pie
                  data={[
                    { name: "Windows", value: 60 },
                    { name: "AndroidOS", value: 40 },
                  ]}
                  cx="50%"
                  cy="50%"
                  innerRadius={40}
                  outerRadius={80}
                  paddingAngle={5}
                  dataKey="value"
                >
                  <Cell fill="#4285F4" />
                  <Cell fill="#FF6D00" />
                </Pie>
                <Tooltip />
              </PieChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>

        {/* Most Views Labels Table */}
        <Card className="bg-white">
          <CardHeader className="bg-gray-50 border-b">
            <CardTitle className="text-center text-sm font-bold">MOST VIEWS LABELS</CardTitle>
          </CardHeader>
          <CardContent className="p-0">
            <div className="overflow-hidden">
              <table className="w-full">
                <thead>
                  <tr className="bg-gray-50">
                    <th className="px-4 py-2 text-left text-sm font-semibold">Nome Della Carta</th>
                    <th className="px-4 py-2 text-left text-sm font-semibold">Visitatori</th>
                  </tr>
                </thead>
                <tbody>
                  {topLabels.map((label, index) => (
                    <tr key={index} className="border-b border-gray-100">
                      <td className="px-4 py-2 text-sm">{label.name}</td>
                      <td className="px-4 py-2 text-sm">{label.visitors}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}
