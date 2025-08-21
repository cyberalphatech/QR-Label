"use client"

import { useState } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Badge } from "@/components/ui/badge"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table"
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from "@/components/ui/dropdown-menu"
import { Search, Filter, MoreHorizontal, Eye, Edit, Copy, Trash2, QrCode, Wine, Calendar, Award } from "lucide-react"

const mockLabels = [
  {
    id: 1,
    name: "Chianti Classico DOCG",
    vintage: "2021",
    type: "Red Wine",
    status: "Published",
    created: "2024-01-15",
    qrGenerated: true,
    certifications: ["DOCG", "EU DOP"],
  },
  {
    id: 2,
    name: "Prosecco di Valdobbiadene",
    vintage: "2023",
    type: "Sparkling",
    status: "Draft",
    created: "2024-01-10",
    qrGenerated: false,
    certifications: ["DOCG"],
  },
  {
    id: 3,
    name: "Barolo Riserva",
    vintage: "2019",
    type: "Red Wine",
    status: "Published",
    created: "2024-01-08",
    qrGenerated: true,
    certifications: ["DOCG", "EU DOP"],
  },
  {
    id: 4,
    name: "Pinot Grigio IGT",
    vintage: "2023",
    type: "White Wine",
    status: "Published",
    created: "2024-01-05",
    qrGenerated: true,
    certifications: ["IGT"],
  },
  {
    id: 5,
    name: "Brunello di Montalcino",
    vintage: "2020",
    type: "Red Wine",
    status: "Draft",
    created: "2024-01-03",
    qrGenerated: false,
    certifications: ["DOCG"],
  },
]

export function WineLabelList() {
  const [searchTerm, setSearchTerm] = useState("")
  const [filterStatus, setFilterStatus] = useState("all")

  const filteredLabels = mockLabels.filter((label) => {
    const matchesSearch =
      label.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      label.vintage.includes(searchTerm) ||
      label.type.toLowerCase().includes(searchTerm.toLowerCase())
    const matchesFilter = filterStatus === "all" || label.status.toLowerCase() === filterStatus
    return matchesSearch && matchesFilter
  })

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h2 className="text-3xl font-sans font-bold">Wine Labels</h2>
          <p className="text-muted-foreground">Manage your wine label collection</p>
        </div>
        <Button className="bg-accent hover:bg-accent/90">
          <Wine className="w-4 h-4 mr-2" />
          Create New Label
        </Button>
      </div>

      {/* Search and Filter */}
      <Card>
        <CardContent className="pt-6">
          <div className="flex flex-col sm:flex-row gap-4">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground w-4 h-4" />
              <Input
                placeholder="Search labels by name, vintage, or type..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="pl-10"
              />
            </div>
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Button variant="outline">
                  <Filter className="w-4 h-4 mr-2" />
                  Filter: {filterStatus === "all" ? "All" : filterStatus}
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent>
                <DropdownMenuItem onClick={() => setFilterStatus("all")}>All Labels</DropdownMenuItem>
                <DropdownMenuItem onClick={() => setFilterStatus("published")}>Published</DropdownMenuItem>
                <DropdownMenuItem onClick={() => setFilterStatus("draft")}>Draft</DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
        </CardContent>
      </Card>

      {/* Labels Table */}
      <Card>
        <CardHeader>
          <CardTitle>Labels ({filteredLabels.length})</CardTitle>
          <CardDescription>Your wine label collection</CardDescription>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Wine</TableHead>
                <TableHead>Type</TableHead>
                <TableHead>Vintage</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Certifications</TableHead>
                <TableHead>QR Code</TableHead>
                <TableHead>Created</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredLabels.map((label) => (
                <TableRow key={label.id}>
                  <TableCell>
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 bg-muted rounded-lg flex items-center justify-center">
                        <Wine className="w-5 h-5 text-muted-foreground" />
                      </div>
                      <div>
                        <div className="font-medium">{label.name}</div>
                      </div>
                    </div>
                  </TableCell>
                  <TableCell>
                    <Badge variant="outline">{label.type}</Badge>
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-1">
                      <Calendar className="w-4 h-4 text-muted-foreground" />
                      {label.vintage}
                    </div>
                  </TableCell>
                  <TableCell>
                    <Badge variant={label.status === "Published" ? "default" : "secondary"}>{label.status}</Badge>
                  </TableCell>
                  <TableCell>
                    <div className="flex gap-1">
                      {label.certifications.map((cert, index) => (
                        <Badge key={index} variant="outline" className="text-xs">
                          <Award className="w-3 h-3 mr-1" />
                          {cert}
                        </Badge>
                      ))}
                    </div>
                  </TableCell>
                  <TableCell>
                    {label.qrGenerated ? (
                      <Badge variant="default" className="bg-green-100 text-green-800">
                        <QrCode className="w-3 h-3 mr-1" />
                        Generated
                      </Badge>
                    ) : (
                      <Badge variant="secondary">Pending</Badge>
                    )}
                  </TableCell>
                  <TableCell className="text-muted-foreground">
                    {new Date(label.created).toLocaleDateString()}
                  </TableCell>
                  <TableCell className="text-right">
                    <DropdownMenu>
                      <DropdownMenuTrigger asChild>
                        <Button variant="ghost" className="h-8 w-8 p-0">
                          <MoreHorizontal className="h-4 w-4" />
                        </Button>
                      </DropdownMenuTrigger>
                      <DropdownMenuContent align="end">
                        <DropdownMenuItem>
                          <Eye className="mr-2 h-4 w-4" />
                          View Details
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                          <Edit className="mr-2 h-4 w-4" />
                          Edit Label
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                          <Copy className="mr-2 h-4 w-4" />
                          Duplicate
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                          <QrCode className="mr-2 h-4 w-4" />
                          Generate QR
                        </DropdownMenuItem>
                        <DropdownMenuItem className="text-destructive">
                          <Trash2 className="mr-2 h-4 w-4" />
                          Delete
                        </DropdownMenuItem>
                      </DropdownMenuContent>
                    </DropdownMenu>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>
    </div>
  )
}
